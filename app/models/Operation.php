<?php 
    class Operation extends Model{ 

        /**
        * Get all operations for a specific user
        * 
        * @param int $userId The ID of the user
        * @return array List of all operations
        */

        public function getAllByUser($userId) {
            $query = $this->db->prepare("SELECT o.*, c.category_name, c.type 
            FROM Operation o
            JOIN Category c ON o.category_id = c.category_id
            WHERE c.user_id = :user_id");
            $query->execute([
                'user_id' => $userId
            ]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
        * Get a single operation by its ID and user
        * 
        * @param int $userId The ID of the user
        * @param int $operationId The ID of the operation
        * @return array|null The operation details or null if not found
        */

        public function getById($userId, $operationId){
            $query = $this->db->prepare("SELECT o.*, c.category_name, c.type 
            FROM Operation o
            JOIN Category c ON o.category_id = c.category_id
            WHERE o.operation_id = :operation_id AND c.user_id = :user_id ");
            $query->execute([
                'user_id' => $userId,
                'operation_id' => $operationId
            ]);
            return $query->fetch(PDO::FETCH_ASSOC);
        }

        /**
        * Create a new operation for a specific user and category
        *  
        * @param int $userId The ID of the user
        * @param array $data The operation data (category_id, amount, description)
        * @return void
        */

        public function create($userId, $data){
            // NEED TO BE UPDATE IN FUTURE. CREATE A SCOPE OF CATEGORIES OF CURRENT USER, FROM WHICH HE/SHE WILL CHOOSE
            // Verify that Category with such id belongs to current User
            $query = $this->db->prepare("SELECT 1 FROM Category WHERE category_id = :category_id AND user_id = :user_id");
            $query->execute([
                'category_id' => $data['category_id'],
                'user_id' => $userId
            ]);

            if (!$query->fetch()) {
                throw new Exception("Category does not belong to the user.");
            }

            // Insert the operation
            $query = $this->db->prepare(" INSERT INTO Operation (user_id, category_id, operation_amount, operation_description) 
            VALUES (:user_id, :category_id, :amount, :description)");
            $query->execute([
                'user_id' => $userId,
                'category_id' => $data['category_id'],
                'amount' => $data['operation_amount'],
                'description' => $data['operation_description']
            ]);
        }

        /**
        * Update an existing operation
        *             
        * @param int $userId The ID of the user
        * @param int $operationId The ID of the operation
        * @param array $data The updated operation data (category_id, amount, description)
        * @return void
        */

        public function update($userId, $operationId, $data){
            // NEED TO BE UPDATE IN FUTURE. CREATE A SCOPE OF CATEGORIES OF CURRENT USER, FROM WHICH HE/SHE WILL CHOOSE
            // Verify that Category with such id belongs to current User
            $query = $this->db->prepare("SELECT 1 FROM Category WHERE category_id = :category_id AND user_id = :user_id");
            $query->execute([
                'category_id' => $data['category_id'],
                'user_id' => $userId
            ]);

            if (!$query->fetch()) {
                throw new Exception("Category does not belong to the user.");
            }

            // Update the operation
            $query = $this->db->prepare("UPDATE Operation (user_id, category_id, operation_amount, operation_description) 
            VALUES (:user_id, :category_id, :amount, :description)");
            $query->execute([
                'user_id' => $userId,
                'category_id' => $data['category_id'],
                'amount' => $data['operation_amount'],
                'description' => $data['operation_description']
            ]);
        }

        /**
        * Delete an operation by its ID
        * 
        * @param int $userId The ID of the user
        * @param int $operationId The ID of the operation
        * @return void
        */

        public function delete($userId, $operationId){
            $query = $this->db->prepare("DELETE FROM Operation
            WHERE operation_id = :operation_id AND user_id = :user_id");
            $query->execute([
                'operation_id' => $operationId,
                'user_id' => $userId
            ]);
        }
    }
?>