<?php
class Database
{
    private $conn;

    public function connect($host, $username, $password, $dbname)
    {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        try {
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function insert($table, $columns, $values)
    {
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
    }

    public function insertOrder($user_id, $date, $room, $ext, $comment, $total, $status)
    {
        $columns = "user_id, date, room, ext, comment, total, status";
        $values = "'$user_id', '$date', '$room', '$ext', '$comment', '$total', $status";
        $this->insert('orders', $columns, $values);
        return $this->lastInsertId();
    }

    public function insertOrderProduct($order_id, $product_id, $quantity, $price, $user_id)
    {
        $columns = "order_id, user_id, product_id, quantity, price";
        $values = "'$order_id', '$user_id', '$product_id', '$quantity', '$price'";
        $this->insert('orders_products', $columns, $values);
    }

    public function select($table)
    {
        $sql = "SELECT * FROM $table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRow($table, $field, $value)
    {
        $sql = "SELECT * FROM $table WHERE $field = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAll($table, $field, $value)
    {
        $sql = "SELECT * FROM $table WHERE $field = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getRows($query, $params = [])
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($table, $data, $id)
    {
        $sql = "UPDATE $table SET $data WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
    }





    public function delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }
    public function checkIfUserExists($table, $email)
    {
        $sql = "SELECT * FROM $table WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);


        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        return $userData !== false ? $userData : null;
    }

    public function changePasswordByID($randomNumber, $newPassword)
    {
        $user_id = $_COOKIE['user_id'];
        $codeRow = $this->getRow("forget_password", "user_id",  $user_id);
        if ($codeRow !== false) {
            if ($randomNumber == $codeRow['random_number']) {
                $this->update('users', "password = $newPassword", $user_id);
                $this->delete('forget_password', $codeRow['id']);
                header("location:../home.php");
            } else {
                echo "you have entered wrong or expired code please try again";
            }
        } else {
            echo "there's no code";
        }
    }

    public function getLatestUserProducts($user_id)
    {
        $sql = "SELECT DISTINCT p.id, p.name, p.image, p.price 
                FROM products p 
                JOIN orders_products op ON p.id = op.product_id 
                JOIN orders o ON op.order_id = o.id 
                WHERE o.user_id = ? 
                ORDER BY o.date DESC, op.order_id DESC 
                LIMIT 3";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function selectOrder($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function userAllOrders($id)
    {
        $sql = "SELECT SUM(total) AS total_amount FROM orders WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_amount'] ? $result['total_amount'] : 0;
    }
    public function getUserTotals() {
        $sql = "SELECT user_id, SUM(total) AS total_amount 
                FROM orders 
                GROUP BY user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOrdersByUser($user_id) {
        $sql = "SELECT o.date AS order_date, o.id AS order_id, op.quantity, op.price 
                FROM orders o 
                JOIN orders_products op ON o.id = op.order_id 
                WHERE o.user_id = ? 
                ORDER BY o.date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRowsWithDateFilter($sql, $startDate, $endDate, $params = []) {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(array_merge($params, [$startDate, $endDate]));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getOrdersByUserAndDate($user_id, $from_date, $to_date) {
        $sql = "SELECT o.date AS order_date, o.id AS order_id, op.quantity, op.price 
                FROM orders o 
                JOIN orders_products op ON o.id = op.order_id 
                WHERE o.user_id = ? AND o.date BETWEEN ? AND ?
                ORDER BY o.date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id, $from_date, $to_date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 
    public function getUserOrders($user_id)
    {
        $sql = "
        SELECT 
            o.id, 
            o.date, 
            o.room, 
            o.ext, 
            o.total, 
            op.product_id, 
            op.quantity, 
            p.image, 
            p.name AS product_name,
            p.price,
            u.name AS user_name
        FROM 
            orders o 
        JOIN 
            orders_products op ON o.id = op.order_id
        JOIN 
            products p ON op.product_id = p.id
        JOIN 
            users u ON o.user_id = u.id
        WHERE 
            o.user_id = ? AND o.status = 1
        ORDER BY 
            o.date DESC;
    ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
