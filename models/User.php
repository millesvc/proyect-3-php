<?php
/**
 * Modelo User.
 * Compatible con PHP 7.3.
 */

require_once BASE_PATH . '/core/Model.php';

class User extends Model {
    private $table = 'users';

    public function create($name, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        $sql = "INSERT INTO {$this->table} (name, email, password) VALUES (:name, :email, :password)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));
        $stmt->bindValue(':email', strtolower(trim($email)));
        $stmt->bindValue(':password', $hashedPassword);

        return $stmt->execute();
    }

    public function findByEmail($email) {
        $sql = "SELECT id, name, email, password, created_at FROM {$this->table} WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', strtolower(trim($email)));
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user : null;
    }

    public function findById($id) {
        $sql = "SELECT id, name, email, created_at FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? $user : null;
    }

    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', strtolower(trim($email)));
        $stmt->execute();

        return ((int) $stmt->fetchColumn()) > 0;
    }

    public function verifyPassword($plainPassword, $hashedPassword) {
        return password_verify($plainPassword, $hashedPassword);
    }
}
