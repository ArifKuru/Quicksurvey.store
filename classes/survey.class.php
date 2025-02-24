<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/config/config.php";

class Survey {
    // Create (INSERT) new survey
        /**
     * Creates a new survey record in the database.
     *
     * @param int $created_by The ID of the user who created the survey.
     * @param string $title The title of the survey.
     * @param string $description A brief description of the survey.
     * @param string $exp_date The expiration date of the survey in 'YYYY-MM-DD' format.
     * @param string $hash_id A unique hash identifier for the survey.
     * @return bool Returns true on success or false on failure.
     */
    static public function create($created_by, $title, $description, $exp_date, $hash_id) {
        global $pdo;
        $sql = "INSERT INTO survey (created_by, title, description, exp_date, hash_id) 
                VALUES (:created_by, :title, :description, :exp_date, :hash_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':exp_date', $exp_date);
        $stmt->bindParam(':hash_id', $hash_id);
        return $stmt->execute();
    }

    // Read (SELECT) a single survey by ID
        /**
     * Retrieves a single survey record from the database by its ID.
     *
     * @param int $id The ID of the survey to retrieve.
     * @return array|false Returns an associative array of the survey data if found, or false if no survey is found.
     */
    static public function read($id) {
        global $pdo;
        $sql = "SELECT * FROM survey WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Update (UPDATE) an existing survey (only non-null values will be updated)
        /**
     * Updates an existing survey record in the database with the provided non-null values.
     *
     * @param int $id The ID of the survey to update.
     * @param string|null $title The new title for the survey. If null, the title will not be updated.
     * @param string|null $description The new description for the survey. If null, the description will not be updated.
     * @param string|null $exp_date The new expiration date for the survey in 'YYYY-MM-DD' format. If null, the expiration date will not be updated.
     * @return bool Returns true if the update was successful, or false if no fields were provided for update.
     */
    static public function update($id, $title = null, $description = null, $exp_date = null, $isPrivacyMode = null, $backgroundColor = null, $fontColor = null) {
        global $pdo;
        $sql = "UPDATE survey SET ";
        $params = [];
        $updates = [];

        // Her bir parametreyi kontrol et ve sorguya ekle
        if ($title !== null) {
            $updates[] = "title = :title";
            $params[':title'] = $title;
        }
        if ($description !== null) {
            $updates[] = "description = :description";
            $params[':description'] = $description;
        }
        if ($exp_date !== null) {
            $updates[] = "exp_date = :exp_date";
            $params[':exp_date'] = $exp_date;
        }
        if ($isPrivacyMode !== null) {
            $updates[] = "isPrivacyMode = :isPrivacyMode";
            $params[':isPrivacyMode'] = (int) $isPrivacyMode; // Boolean değeri integer olarak saklanabilir
        }
        if ($backgroundColor !== null) {
            $updates[] = "backgroundColor = :backgroundColor";
            $params[':backgroundColor'] = $backgroundColor;
        }
        if ($fontColor !== null) {
            $updates[] = "fontColor = :fontColor";
            $params[':fontColor'] = $fontColor;
        }

        // Güncelleme sorgusunu oluştur ve çalıştır
        if (!empty($updates)) {
            $sql .= implode(", ", $updates) . " WHERE id = :id";
            $params[':id'] = $id;

            $stmt = $pdo->prepare($sql);
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            return $stmt->execute();
        } else {
            return false; // Güncellenecek alan yok
        }
    }
    // Delete (DELETE) a survey by ID
        /**
     * Deletes a survey record from the database by its ID.
     *
     * @param int $id The ID of the survey to delete.
     * @return bool Returns true if the deletion was successful, or false on failure.
     */
    static public function delete($id) {
        global $pdo;
        $sql = "UPDATE survey SET isDeleted = 1 WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Get all survey (optional: filtered by created_by)
    /**
     * Retrieves all survey records from the database, optionally filtered by the creator's ID.
     *
     * @param int|null $created_by The ID of the user who created the survey. If null, all survey are retrieved.
     * @return array An array of associative arrays, each representing a survey record.
     */
    static public function getAll($created_by = null) {
        global $pdo;
        if ($created_by !== null) {
            $sql = "SELECT * FROM survey WHERE created_by = :created_by and isDeleted=0";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':created_by', $created_by);
        } else {
            $sql = "SELECT * FROM survey";
            $stmt = $pdo->prepare($sql);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a survey by its hash_id
        /**
     * Retrieves a survey record from the database by its unique hash identifier.
     *
     * @param string $hash_id The unique hash identifier of the survey to retrieve.
     * @return array|false Returns an associative array of the survey data if found, or false if no survey is found.
     */
    static public function getByHashId($hash_id) {
        global $pdo;
        $sql = "SELECT * FROM survey WHERE hash_id = :hash_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':hash_id', $hash_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function getById($id)
    {
        global $pdo;
        $sql = "SELECT * FROM survey WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    static public function getAllDeleted($created_by = null) {
        global $pdo;
        if ($created_by !== null) {
            $sql = "SELECT * FROM survey WHERE created_by = :created_by and isDeleted=1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':created_by', $created_by);
        } else {
            $sql = "SELECT * FROM survey";
            $stmt = $pdo->prepare($sql);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function getFirstSurveyFieldId($hash_id) {
        global $pdo;

        try {
            // 1. Survey tablosundan hash_id ile eşleşen id'yi alın
            $sqlSurvey = "SELECT id FROM survey WHERE hash_id = :hash_id LIMIT 1";
            $stmtSurvey = $pdo->prepare($sqlSurvey);
            $stmtSurvey->bindParam(':hash_id', $hash_id, PDO::PARAM_STR);
            $stmtSurvey->execute();

            $survey = $stmtSurvey->fetch(PDO::FETCH_ASSOC);

            // Eğer survey bulunamadıysa null döndür
            if (!$survey) {
                return null;
            }

            $survey_id = $survey['id'];

            // 2. Survey_fields tablosunda bu survey_id ile eşleşen en küçük id'yi bulun
            $sqlField = "SELECT id FROM survey_fields WHERE survey_id = :survey_id ORDER BY id ASC LIMIT 1";
            $stmtField = $pdo->prepare($sqlField);
            $stmtField->bindParam(':survey_id', $survey_id, PDO::PARAM_INT);
            $stmtField->execute();

            $field = $stmtField->fetch(PDO::FETCH_ASSOC);

            // Eğer survey_field bulunamadıysa null döndür
            if (!$field) {
                return null;
            }

            return $field['id'];
        } catch (PDOException $e) {
            // Hata durumunda hata mesajını loglamanız önerilir
            error_log("Database error: " . $e->getMessage());
            return null;
        }
    }

    public static function publishTheSurvey($survey){
        global $pdo;

        try {
            $sql = "UPDATE survey SET publish_date = NOW() WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $survey['id'], PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Database error: ". $e->getMessage());
            return false;
        }
    }

    public static function getCountOfFields($survey_id){
        global $pdo;

        try {
            $sql = "SELECT COUNT(*) as count FROM survey_fields WHERE survey_id = :survey_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':survey_id', $survey_id, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            return $count['count'];
        } catch (PDOException $e) {
            error_log("Database error: ". $e->getMessage());
            return null;
        }
    }

}
?>
