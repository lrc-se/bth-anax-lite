<?php

namespace LRC\User;

class Functions
{
    private $db;
    
    
    public function __construct($db)
    {
        $this->db = $db;
    }
    
    public function getById($id)
    {
        return $this->db->queryOne('SELECT * FROM oophp_user WHERE id = ?;', $id, '\LRC\User\User');
    }

    public function getByUsername($name)
    {
        return $this->db->queryOne('SELECT * FROM oophp_user WHERE username = ?;', $name, '\LRC\User\User');
    }

    public function getAll()
    {
        return $this->db->query('SELECT * FROM oophp_user;', [], '\LRC\User\User');
    }
    
    public function save($user)
    {
        $params = get_object_vars($user);
        if ($user->id) {
            $num = $this->db->update('UPDATE oophp_user SET username = :username, password = :password, birthdate = :birthdate, email = :email, image = :image, level = :level, active = :active WHERE id = :id;', $params);
        } else {
            unset($params['id']);
            $num = $this->db->update('INSERT INTO oophp_user (username, password, birthdate, email, image, level, active) VALUES (:username, :password, :birthdate, :email, :image, :level, :active);', $params);
            if ($num) {
                $user->id = $this->db->getInsertId();
            }
        }
        return ($num == 1);
    }
    
    public function remove($id)
    {
        return ($this->db->update('DELETE FROM oophp_user WHERE id = ? LIMIT 1;', $id) == 1);
    }
    
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
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
            $active = $req->getPost('active', null);
        } else {
            $level = 0;
            $active = 1;
        }
        $user->level = $level;
        $user->active = $active;
        return $user;
    }
}