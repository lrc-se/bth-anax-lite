<?php

namespace LRC\Webshop;

/**
 * Webshop product functions class.
 */
class ProductFunctions
{
    const TABLE = 'oophp_product';
    
    private $db;
    private $joinSql = ' FROM ' . self::TABLE . ' p JOIN ' . CategoryFunctions::ASSOC_TABLE . ' pc ON p.id = pc.prodId JOIN ' . CategoryFunctions::TABLE . ' c ON pc.catId = c.id';
    
    
    /**
     * Constructor.
     *
     * @param   \LRC\Database\Database  $db     Framework database connection object.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    /**
     * Retrieves a product by ID.
     *
     * @param   int         $id     The ID (primary key) of the product to retrieve.
     * @return  Product|null        The retrieved product, or null if no product found.
     */
    public function getById($id)
    {
        $product = $this->db->queryOne('SELECT * FROM ' . self::TABLE . ' WHERE id = ?;', $id, '\LRC\Webshop\Product');
        if ($product) {
            $product->categoryIds = $this->getCategories($product, true);
        }
        return $product;
    }

    /**
     * Retrieves procuts by category.
     *
     * @param   string      $category   The category of the products to retrieve.
     * @return  Product[]               An array of the retrieved products.
     */
    public function getByCategory($category)
    {
        $products = $this->db->query('SELECT DISTINCT p.*' . $this->joinSql . ' WHERE c.name = ?;', $category, '\LRC\Webshop\Product');
        foreach ($products as $product) {
            $product->categoryIds = $this->getCategories($product, true);
        }
        return $products;
    }

    /**
     * Retrieves all products.
     *
     * @param   string      $order  Optional SQL order.
     * @return  Product[]           An array of all products.
     */
    public function getAll($order = null)
    {
        return $this->getMatching(null, $order);
    }
    
    /**
     * Retrieves all products matching a search query.
     *
     * @param   string      $match  Search pattern.
     * @param   string      $order  Optional SQL order.
     * @param   int         $limit  How many results to return at most (0 means no limit).
     * @param   int         $offset How many rows to skip in the result set.
     * @return  Product[]           An array of all matching products.
     */
    public function getMatching($match = null, $order = null, $limit = null, $offset = null)
    {
        $sql = 'SELECT * FROM ' . self::TABLE . ' p';
        $params = [];
        if (!is_null($match)) {
            $sql = 'SELECT DISTINCT p.*' . $this->joinSql . ' WHERE p.name LIKE :match OR p.description LIKE :match OR c.name LIKE :match';
            $params = ['match' => "%$match%"];
        }
        if (!is_null($order)) {
            $sql .= " ORDER BY p.$order";
        }
        if (!empty($limit) && $limit > 0) {
            $sql .= " LIMIT $limit";
        }
        if (!empty($offset) && $offset > 0) {
            $sql .= " OFFSET $offset";
        }
        $products = $this->db->query("$sql;", $params, '\LRC\Webshop\Product');
        foreach ($products as $product) {
            $product->categoryIds = $this->getCategories($product, true);
        }
        return $products;
    }
    
    /**
     * Returns the total number of products.
     *
     * @param   string  $match  Optional search pattern.
     * @return  int             The number of products matching the search pattern (all products if no pattern specified).
     */
    public function getTotal($match = null)
    {
        $sql = 'SELECT COUNT(id) AS total FROM ' . self::TABLE;
        $params = [];
        if (!is_null($match)) {
            $sql = 'SELECT COUNT(DISTINCT p.id) AS total' . $this->joinSql . ' WHERE p.name LIKE :match OR p.description LIKE :match OR c.name LIKE :match';
            $params = ['match' => "%$match%"];
        }
        $num = $this->db->queryOne("$sql;", $params);
        return (!is_null($num) ? $num->total : 0);
    }
    
    /**
     * Returns the categories to which a product belongs.
     *
     * @param   Product|int         $product    The product (object), or the ID of the product.
     * @param   bool                $onlyIds    Whether to only fetch category IDs rather than whole category objects.
     * @return  Category[]|int[]                An array of categories or category IDs.
     */
    public function getCategories($product, $onlyIds = false)
    {
        if ($product instanceof Product) {
            $id = $product->id;
        } else {
            $id = $product;
        }
        $sql = $this->joinSql . ' WHERE p.id = ? ORDER BY c.name;';
        if (!$onlyIds) {
            return $this->db->query('SELECT c.*' . $sql, $id, '\LRC\Webshop\Category');
        } else {
            return $this->db->queryColumn('SELECT c.id' . $sql, $id);
        }
    }
    
    /**
     * Saves a product to database.
     *
     * @param   Product     $product    The product to save.
     * @return  bool                    True if the update was successful, false otherwise.
     */
    public function save($product)
    {
        $params = get_object_vars($product);
        unset($params['stock']);
        unset($params['categoryIds']);
        $db = $this->db->getConnection();
        $db->beginTransaction();
        if ($product->id) {
            $num = $this->db->update('UPDATE ' . self::TABLE . ' SET name = :name, price = :price, image = :image, description = :description, available = :available WHERE id = :id;', $params);
        } else {
            unset($params['id']);
            $num = $this->db->update('INSERT INTO ' . self::TABLE . ' (name, price, image, description, available) VALUES (:name, :price, :image, :description, :available);', $params);
            if ($num) {
                $product->id = $this->db->getInsertId();
            } else {
                $db->rollBack();
                return false;
            }
        }
        if (!$this->saveCategories($product)) {
            $db->rollBack();
            return false;
        }
        return $db->commit();
    }
    
    /**
     * Saves product category associations to database.
     *
     * @param   Product     $product    The product to save category associations for.
     * @return  bool                    True if the update was successful, false otherwise.
     */
    private function saveCategories($product)
    {
        $categories = [];
        foreach ($product->categoryIds as $catId) {
            $categories[] = [$product->id, $catId];
        }
        $this->db->update('DELETE FROM ' . CategoryFunctions::ASSOC_TABLE . ' WHERE prodId = ?;', $product->id);
        return ($this->db->updateAll('INSERT INTO ' . CategoryFunctions::ASSOC_TABLE . ' VALUES (?, ?);', $categories) == count($categories));
    }
    
    /**
     * Updates the stock level for a product.
     *
     * @param   int     $id     The ID (PK) of the product to update.
     * @param   int     $amount How many units to add to the stock level.
     * @return  bool            True if the update was successful, false otherwise.
     */
    public function addStock($id, $amount)
    {
        return ($this->db->update('CALL addStock(?, ?);', [$id, $amount]) == 1);
    }
    
    /**
     * Returns validation errors for a submitted product form.
     *
     * @param   \Anax\Request\Request   $req    Framework request object.
     * @return  string[]                        An array of error messages (empty if all fields validate).
     */
    public function getValidationErrors($req)
    {
        $errors = [];
        $name = trim($req->getPost('name'));
        $price = trim($req->getPost('price'));
        if ($price === '') {
            $price = 0;
        }
        $categories = $req->getPost('category');
        $description = trim($req->getPost('description'));
        if ($name === '') {
            $errors[] = 'Produktnamn måste anges.';
        }
        if (!is_numeric($price) || (int)$price < 0) {
            $errors[] = 'Priset måste vara ett positivt heltal eller 0.';
        }
        if (empty($categories)) {
            $errors[] = 'Produkten måste ingå i minst en kategori.';
        }
        if ($description === '') {
            $errors[] = 'Produkten måste ha en beskrivning.';
        }
        return $errors;
    }
    
    /**
     * Populates a product object with data from a submitted product form.
     *
     * @param   \Anax\Request\Request   $req    Framework request object.
     * @return  Product                         The instantiated product object.
     */
    public function populateProduct($req)
    {
        $product = new Product();
        $id = trim($req->getPost('id'));
        if ($id !== '') {
            $product->id = $id;
        }
        $product->name = trim($req->getPost('name'));
        $product->price = (int)trim($req->getPost('price'));
        $image = trim($req->getPost('image'));
        $product->image = (!empty($image) ? $image : null);
        $product->description = trim($req->getPost('description'));
        $product->available = (bool)$req->getPost('available');
        $product->categoryIds = $req->getPost('category', []);
        return $product;
    }
}
