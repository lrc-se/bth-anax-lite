<?php

namespace LRC\User;

/**
 * User functions class.
 */
class Functions
{
    const TABLE = 'oophp_user';
    
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
     * Retrieves a user by ID.
     *
     * @param   int         $id     The ID (primary key) of the user to retrieve.
     * @return  User|null           The retrieved user, or null if no user found.
     */
    public function getById($id)
    {
        return $this->db->queryOne('SELECT * FROM ' . self::TABLE . ' WHERE id = ?;', $id, '\LRC\User\User');
    }

    /**
     * Retrieves a user by username.
     *
     * @param   string      $name   The username of the user to retrieve.
     * @return  User|null           The retrieved user, or null if no user found.
     */
    public function getByUsername($name)
    {
        return $this->db->queryOne('SELECT * FROM ' . self::TABLE . ' WHERE username = ?;', $name, '\LRC\User\User');
    }

    /**
     * Retrieves all users.
     *
     * @param   string      $order  Optional SQL order.
     * @return  User[]              An array of all users.
     */
    public function getAll($order = null)
    {
        return $this->getMatching(null, $order);
    }
    
    /**
     * Retrieves all users matching a search query.
     *
     * @param   string  $match  Search pattern.
     * @param   string  $order  Optional SQL order.
     * @param   int     $limit  How many results to return at most (0 means no limit).
     * @param   int     $offset How many rows to skip in the result set.
     * @return  User[]          An array of all matching users.
     */
    public function getMatching($match = null, $order = null, $limit = null, $offset = null)
    {
        $sql = 'SELECT * FROM ' . self::TABLE;
        $params = [];
        if (!is_null($match)) {
            $sql .= ' WHERE username LIKE :match OR birthdate LIKE :match OR email LIKE :match';
            $params = ['match' => "%$match%"];
        }
        if (!is_null($order)) {
            $sql .= " ORDER BY $order";
        }
        if (!empty($limit) && $limit > 0) {
            $sql .= " LIMIT $limit";
        }
        if (!empty($offset) && $offset > 0) {
            $sql .= " OFFSET $offset";
        }
        return $this->db->query("$sql;", $params, '\LRC\User\User');
    }
    
    /**
     * Returns the total number of users.
     *
     * @param   string  $match  Optional search pattern.
     * @return  int             The number of users matching the search pattern (all users if no pattern specified).
     */
    public function getTotal($match = null)
    {
        $sql = 'SELECT COUNT(id) AS total FROM ' . self::TABLE;
        $params = [];
        if (!is_null($match)) {
            $sql .= ' WHERE username LIKE :match OR birthdate LIKE :match OR email LIKE :match';
            $params = ['match' => "%$match%"];
        }
        $num = $this->db->queryOne("$sql;", $params);
        return (!is_null($num) ? $num->total : 0);
    }
    
    /**
     * Saves a user to database.
     *
     * @param   User    $user   The user to save.
     * @return  bool            True if the update was successful, false otherwise.
     */
    public function save($user)
    {
        $params = get_object_vars($user);
        if ($user->id) {
            $num = $this->db->update('UPDATE ' . self::TABLE . ' SET username = :username, password = :password, birthdate = :birthdate, email = :email, image = :image, level = :level, active = :active WHERE id = :id;', $params);
        } else {
            unset($params['id']);
            $num = $this->db->update('INSERT INTO ' . self::TABLE . ' (username, password, birthdate, email, image, level, active) VALUES (:username, :password, :birthdate, :email, :image, :level, :active);', $params);
            if ($num) {
                $user->id = $this->db->getInsertId();
            }
        }
        return ($num == 1);
    }
    
    /**
     * Removes a user from database.
     *
     * @param   int     $id     The ID (primary key) of the user to remove.
     * @return  bool            True if the removal was successful, false otherwise.
     */
    public function remove($id)
    {
        return ($this->db->update('DELETE FROM ' . self::TABLE . ' WHERE id = ? LIMIT 1;', $id) == 1);
    }
    
    /**
     * Returns validation errors for a submitted user form.
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
        $id = trim($req->getPost('id'));
        $username = trim($req->getPost('username'));
        $password = trim($req->getPost('password'));
        $password2 = trim($req->getPost('password2'));
        $birthdate = trim($req->getPost('birthdate'));
        $email = trim($req->getPost('email'));
        if ($username === '') {
            $errors[] = 'Användarnamn måste anges.';
        } else {
            $user = $this->getByUsername($username);
            $oldUser = $this->getById($id);
            if (!is_null($user) && (!$oldUser || mb_strtolower($oldUser->username) !== mb_strtolower($username))) {
                $errors[] = "Användarnamnet <strong>$username</strong> är upptaget.";
            }
        }
        if ($password === '') {
            if ($id === '') {
                $errors[] = 'Lösenord måste anges.';
            }
        } else {
            if (strlen($password) < 8) {
                $errors[] = 'Lösenordet måste vara minst 8 tecken långt.';
            } elseif ($password2 !== $password) {
                $errors[] = 'Lösenorden stämmer inte överens.';
            }
        }
        if ($birthdate === '') {
            $errors[] = 'Födelsedatum måste anges.';
        } else {
            $date = \DateTime::createFromFormat('Y-m-d', $birthdate);
            if (!$date || $date->format('Y-m-d') !== $birthdate) {
                $errors[] = 'Ogiltigt datumformat.';
            }
        }
        if ($email === '') {
            $errors[] = 'E-postadress måste anges.';
        } elseif (strpos($email, ' ') !== false || !preg_match('/.+@.+\...+/', $email)) {
            $errors[] = 'Ogiltig e-postadress.';
        }
        return $errors;
    }
    
    /**
     * Populates a user object with data from a submitted user form.
     *
     * @param   \Anax\Request\Request   $req    Framework request object.
     * @param   bool                    $admin  Whether or not the submission was made by an administrator.
     * @return  User                            The instantiated user object.
     */
    public function populateUser($req, $admin = false)
    {
        $user = new User();
        $id = trim($req->getPost('id'));
        if ($id !== '') {
            $user->id = $id;
        }
        $user->username = trim($req->getPost('username'));
        $pass = trim($req->getPost('password'));
        if ($pass !== '') {
            $user->password = password_hash($pass, PASSWORD_DEFAULT);
        } else {
            $oldUser = $this->getById($id);
            $user->password = $oldUser->password;
        }
        $user->birthdate = trim($req->getPost('birthdate'));
        $user->email = trim($req->getPost('email'));
        $image = trim($req->getPost('image'));
        $user->image = (!empty($image) ? $image : null);
        if ($admin) {
            $level = $req->getPost('level', 0);
            $active = $req->getPost('active', 0);
        } else {
            $level = 0;
            $active = 1;
        }
        $user->level = $level;
        $user->active = $active;
        return $user;
    }
}
