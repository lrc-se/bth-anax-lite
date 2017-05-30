<?php

namespace LRC\Webshop;

/**
 * Webshop product category functions.
 */
class CategoryFunctions
{
    const TABLE = 'oophp_category';
    const ASSOC_TABLE = 'oophp_prodcat';
    
    private $db;
    
    
    /**
     * Constructor.
     *
     * @param   \LRC\Database\DbConnection  $db     Framework database connection object.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    /**
     * Retrieves a category by ID.
     *
     * @param   int         $id     The ID (primary key) of the category to retrieve.
     * @return  Category|null       The retrieved category, or null if no category found.
     */
    public function getById($id)
    {
        return $this->db->queryOne('SELECT * FROM ' . self::TABLE . ' WHERE id = ?;', $id, '\LRC\Webshop\Category');
    }

    /**
     * Retrieves all categories.
     *
     * @param   string      $order  Optional SQL order.
     * @return  Category[]          An array of all categories.
     */
    public function getAll($order = 'name')
    {
        $sql = 'SELECT * FROM ' . self::TABLE;
        if (!is_null($order)) {
            $sql .= " ORDER BY $order";
        }
        return $this->db->query("$sql;", [], '\LRC\Webshop\Category');
    }
    
    /**
     * Returns the total number of categories.
     *
     * @return  int     The number of categories.
     */
    public function getTotal()
    {
        $num = $this->db->queryOne('SELECT COUNT(id) AS total FROM ' . self::TABLE . ';');
        return (!is_null($num) ? $num->total : 0);
    }
}
