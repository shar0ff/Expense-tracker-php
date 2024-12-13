<?php 
    session_start();
    require '../database/database.php';

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    if ($page < 1) {
        $page = 1;
    }

    $limit = 20;
    $offset = ($page - 1) * $limit;

    try{
        if (!$pdo) {
            throw new PDOException("Database connection failed");
        }

        $totalCategories = $pdo->query("SELECT COUNT(*) as total FROM Categories")->fetchColumn();
        if ($totalCategories === false) {
            throw new PDOException("Failed to fetch total categories count");
        }

        $query = $pdo->prepare("SELECT * FROM Categories LIMIT :limit OFFSET :offset");
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->bindParam(':offset', $offset, PDO::PARAM_INT);
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($categories === false) {
            throw new PDOException("Failed to fetch categories");
        }
        
        // Calculate the total number of pages
        $pagesNumber = ceil($totalEvents / $limit);
        
        // Return event data and pagination info as JSON
        $response = [
            'categories' => $categories,
            'pagesNumber' => $pagesNumber,
            'currentPage' => $page
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }    
?>