<?php

namespace LRC\Content;

/**
 * Content functions class.
 */
class Functions
{
    const TABLE = 'oophp_content';
    
    private $db;
    
    
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
     * Retrieves a content entry by ID.
     *
     * @param   int         $id     The ID (primary key) of the content entry to retrieve.
     * @return  Content|null        The retrieved content entry, or null if no content found.
     */
    public function getById($id)
    {
        return $this->db->queryOne('SELECT * FROM ' . self::TABLE . ' WHERE id = ?;', $id, '\LRC\Content\Content');
    }

    /**
     * Retrieves a content entry by label.
     *
     * @param   string      $label  The label of the content entry to retrieve.
     * @return  Content|null        The retrieved content entry, or null if no content found.
     */
    public function getByLabel($label)
    {
        return $this->db->queryOne('SELECT * FROM ' . self::TABLE . ' WHERE label = ?;', $label, '\LRC\Content\Content');
    }

    /**
     * Retrieves all content entries of the specified type.
     *
     * @param   string      $type       The type.
     * @param   bool        $active     Whether to only include active entries (published and not marked as deleted).
     * @param   string      $order      Optional SQL order.
     * @param   int         $limit      How many results to return at most (0 means no limit).
     * @param   int         $offset     How many rows to skip in the result set.
     * @return  Content[]               An array of retrieved content entries.
     */
    public function getByType($type, $active = true, $order = null, $limit = null, $offset = null)
    {
        $sql = 'SELECT * FROM ' . self::TABLE . ' WHERE type = ?' . ($active ? ' AND deleted IS NULL AND published IS NOT NULL AND published <= NOW()' : '');
        if (!is_null($order)) {
            $sql .= " ORDER by $order";
        }
        if (!empty($limit) && $limit > 0) {
            $sql .= " LIMIT $limit";
        }
        if (!empty($offset) && $offset > 0) {
            $sql .= " OFFSET $offset";
        }
        return $this->db->query("$sql;", $type, '\LRC\Content\Content');
    }
    
    /**
     * Retrieves all active content entries of type 'page', ordered by publish date.
     *
     * @param   bool        $desc       Whether to use descending order (newest first).
     * @param   int         $limit      How many results to return at most (0 means no limit).
     * @param   int         $offset     How many rows to skip in the result set.
     * @return  Content[]               An array of retrieved content entries.
     */
    public function getPages($desc = false, $limit = null, $offset = null)
    {
        return $this->getByType('page', true, 'published ' . ($desc ? ' DESC' : ' ASC'), $limit, $offset);
    }
    
    /**
     * Retrieves all active content entries of type 'post', ordered by publish date.
     *
     * @param   bool        $desc       Whether to use descending order (newest first).
     * @param   int         $limit      How many results to return at most (0 means no limit).
     * @param   int         $offset     How many rows to skip in the result set.
     * @return  Content[]               An array of retrieved content entries.
     */
    public function getPosts($desc = true, $limit = null, $offset = null)
    {
        return $this->getByType('post', true, 'published ' . ($desc ? ' DESC' : ' ASC'), $limit, $offset);
    }
    
    /**
     * Retrieves all active content entries created by the specified user, with pagination (or all content if no user specified).
     *
     * @param   int         $userId     If present, restricts the results to entries created by the corresponding user.
     * @param   string      $order      Optional SQL order.
     * @param   int         $limit      How many results to return at most (0 means no limit).
     * @param   int         $offset     How many rows to skip in the result set.
     * @return  Content[]               An array of retrieved content entries.
     */
    public function getAll($userId = null, $order = null, $limit = null, $offset = null)
    {
        $sql1 = 'SELECT * FROM ' . self::TABLE;
        $sql2 = '';
        $params = [];
        if (!is_null($userId)) {
            $sql2 .= ' WHERE userId = ? AND deleted IS NULL';
            $params[] = $userId;
        }
        if (!is_null($order)) {
            if (substr($order, 0, 8) == 'username') {
                $sql1 = 'SELECT c.* FROM ' . self::TABLE . ' AS c LEFT OUTER JOIN ' . \LRC\User\Functions::TABLE . ' AS u ON c.userId = u.id';
                $sql2 .= " ORDER BY u.$order";
            } else {
                $sql2 .= " ORDER BY $order";
            }
        }
        if (!empty($limit) && $limit > 0) {
            $sql2 .= " LIMIT $limit";
        }
        if (!empty($offset) && $offset > 0) {
            $sql2 .= " OFFSET $offset";
        }
        return $this->db->query("{$sql1}{$sql2};", $params, '\LRC\Content\Content');
    }
    
    /**
     * Returns the total number of active content entries filtered by creator and/or type (or all content if no user or type specified).
     *
     * @param   int     $userId     If present, restricts the results to entries created by the corresponding user.
     * @param   string  $type       If present, restricts the results to entries of the specified type.
     * @return  int                 Total number of content entries.
     */
    public function getTotal($userId = null, $type = null)
    {
        $sql = 'SELECT COUNT(id) AS total FROM ' . self::TABLE;
        $where = [];
        $params = [];
        if (!is_null($userId)) {
            $where[] = 'userId = ?';
            $params[] = $userId;
        }
        if (!is_null($type)) {
            $where[] = 'type = ?';
            $params[] = $type;
        }
        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where) . ' AND deleted IS NULL';
        }
        $num = $this->db->queryOne("$sql;", $params);
        return (!is_null($num) ? $num->total : 0);
    }
    
    /**
     * Returns the user who created a content entry.
     *
     * @param   Content|int         $content    The content entry (object), or the ID of the content entry.
     * @return  \LRC\User\User|null             The user object, or null if no user found.
     */
    public function getUser($content)
    {
        $ufunc = new \LRC\User\Functions($this->db);
        if ($content instanceof Content) {
            $obj = $ufunc->getById($content->userId);
        } else {
            $content = $this->getById($content);
            $obj = ($content ? $ufunc->getById($content->userId) : null);
        }
        return $obj;
    }
    
    /**
     * Saves a content entry to database.
     *
     * @param   Content $content    The content entry to save.
     * @return  bool                True if the update was successful, false otherwise.
     */
    public function save($content)
    {
        $params = get_object_vars($content);
        unset($params['created']);
        unset($params['updated']);
        unset($params['deleted']);
        if ($params['published'] === 'now') {
            $published = 'NOW()';
            unset($params['published']);
        } else {
            $published = ':published';
        }
        if ($content->id) {
            $num = $this->db->update('UPDATE ' . self::TABLE . " SET userId = :userId, type = :type, label = :label, title = :title, content = :content, formatters = :formatters, updated = NOW(), published = $published WHERE id = :id;", $params);
        } else {
            unset($params['id']);
            $num = $this->db->update('INSERT INTO ' . self::TABLE . " (userId, type, label, title, content, formatters, created, published) VALUES (:userId, :type, :label, :title, :content, :formatters, NOW(), $published);", $params);
            if ($num) {
                $content->id = $this->db->getInsertId();
            }
        }
        return ($num == 1);
    }
    
    /**
     * Marks a content entry as deleted in database.
     *
     * @param   int     $id     The ID (primary key) of the content entry to mark as deleted.
     * @return  bool            True if the update was successful, false otherwise.
     */
    public function remove($id)
    {
        return ($this->db->update('UPDATE ' . self::TABLE . ' SET deleted = NOW() WHERE id = ?;', $id) == 1);
    }
    
    /**
     * Restores a content entry marked as deleted in database.
     *
     * @param   int     $id     The ID (primary key) of the content entry to restore.
     * @return  bool            True if the update was successful, false otherwise.
     */
    public function restore($id)
    {
        return ($this->db->update('UPDATE ' . self::TABLE . ' SET deleted = NULL WHERE id = ?;', $id) == 1);
    }
    
    /**
     * Returns validation errors for a submitted content form.
     *
     * @param   \Anax\Request\Request   $req    Framework request object.
     * @return  string[]                        An array of error messages (empty if all fields validate).
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getValidationErrors($req)
    {
        $errors = [];
        $id = $req->getPost('id');
        $type = $req->getPost('type');
        $label = trim($req->getPost('label'));
        $title = trim($req->getPost('title'));
        $publish = $req->getPost('publish');
        $published = trim($req->getPost('published'));
        if ($title === '') {
            $errors[] = 'Rubrik måste anges.';
        }
        if (!array_key_exists($type, Content::TYPES)) {
            $errors[] = 'Felaktig innehållstyp.';
        }
        if ($type != 'post') {
            if ($label === '') {
                $errors[] = 'Etikett måste anges.';
            } elseif (preg_match('/[^a-z0-9\-]/', mb_strtolower($label))) {
                $errors[] = 'Etiketten får endast innehålla bokstäver A-Z, siffror och bindestreck.';
            } else {
                $content = $this->getByLabel($label);
                if ($content && $content->id != $id) {
                    $errors[] = 'Etiketten finns redan.';
                }
            }
        }
        if ($publish == 'other') {
            if ($published === '') {
                $errors[] = 'Publiceringstid måste anges.';
            } else {
                $date = \DateTime::createFromFormat('Y-m-d H:i:s', $published);
                if (!$date || $date->format('Y-m-d H:i:s') !== $published) {
                    $errors[] = 'Ogiltigt datum- eller tidsformat.';
                } else {
                    $content = $this->getById($id);
                    if ($content) {
                        $updated = ($content->updated ?: ($content->published ?: $content->created));
                        if ($published < $updated) {
                            $errors[] = "Publiceringstiden kan inte sättas tidigare än den senaste uppdateringen ($updated).";
                        }
                    }
                }
            }
        }
        return $errors;
    }
    
    /**
     * Populates a content object with data from a submitted content form.
     *
     * @param   \Anax\Request\Request   $req    Framework request object.
     * @return  Content                         The instantiated content object.
     */
    public function populateEntry($req)
    {
        $content = new Content();
        $content->id = $req->getPost('id');
        $content->type = $req->getPost('type');
        $content->label = ($content->type != 'post' ? trim($req->getPost('label')) : null);
        $content->title = trim($req->getPost('title'));
        $content->content = $req->getPost('content');
        $content->formatters = trim($req->getPost('formatters'));
        switch ($req->getPost('publish')) {
            case 'same':
                $content->published = $this->getById($content->id)->published;
                break;
            case 'un':
                $content->published = null;
                break;
            case 'other':
                $content->published = trim($req->getPost('published'));
                break;
            default:
                $content->published = 'now';
        }
        return $content;
    }
}
