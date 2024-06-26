<?php
include_once str_replace('/', DIRECTORY_SEPARATOR,  '../classes/file-utils.php');
require_once '../classes/db-config.php';
require_once '../classes/db-connector.php';

$_SESSION['organization'] = 'acap';

class CandidatePosition
{
    private static $connection;

    protected static function savePosition($data, $mode)
    {
        // print_r($data);
        // echo "<br>";
        if (self::$connection = DatabaseConnection::connect()) {
            $savedPositions = [];

            self::$connection->begin_transaction();

            foreach ($data as $item) {
                if ($mode === 'sequence') {
                    $savedPositions[] = self::updateSequence($item);
                } else if ($mode === 'delete') {
                    $savedPositions[] = self::deletePosition($item);
                } else if (!empty($item['data_id'])) {
                    // Check if data is not blank
                    if (filter_var($item['data_id'], FILTER_VALIDATE_INT) !== false) {
                        $item['data_id'] = (int) $item['data_id'];
                        self::updatePosition($item);
                    } else {
                        // Data is not an integer
                    }
                } else {
                    // Data is blank
                    $savedPositions[] = self::addPosition($item);
                }
            }

            self::$connection->commit();
            return $savedPositions;
        }
    }

    private static function addPosition($data)
    {

        $sql = "INSERT INTO position (sequence, title, description) VALUES (?, ?, ?)";

        // Prepare the statement
        $stmt = self::$connection->prepare($sql);
        $position = [];
        if ($stmt) {


            $stmt->bind_param("iss", $data['sequence'], $data['value'], $data['description']);
            $stmt->execute();
            $inserted_id = self::$connection->insert_id;
            $position = [
                'input_id' => $data['input_id'],
                'data_id' => $inserted_id,
                'sequence' => $data['sequence'],
                'value' => $data['value'],
                'description' => $data['description']
            ];
        } else {
            echo "Error preparing statement: " . self::$connection->error;
        }
        $stmt->close();
        return $position;
    }

    private static function updatePosition($data)
    {
        $sql = "UPDATE position SET sequence = ?, title = ?, description = ? WHERE position_id = ?";

        // Prepare the statement
        $stmt = self::$connection->prepare($sql);
        $position = [];
        if ($stmt) {


            $stmt->bind_param("issi", $data['sequence'], $data['value'], $data['description'], $data['data_id']);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {

                $position = [
                    'input_id' => $data['input_id'],
                    'data_id' => $data['data_id'],
                    'sequence' => $data['sequence'],
                    'value' => $data['value'],
                    'description' => $data['description']
                ];
            } else {
                // No rows were affected (no matching data_id found)

            }
        } else {
            echo "Error preparing statement: " . self::$connection->error;
        }
        $stmt->close();
        return $position;
    }

    protected static function updateSequence($data)
    {
        $sql = "UPDATE position SET sequence = ? WHERE position_id = ?";

        // Prepare the statement
        $stmt = self::$connection->prepare($sql);
        $position = [];
        if ($stmt) {


            $stmt->bind_param("ii", $data['sequence'], $data['data_id']);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {

                $position = [
                    'input_id' => $data['input_id'],
                    'data_id' => $data['data_id'],
                    'sequence' => $data['sequence'],
                ];
            }
        } else {
            echo "Error preparing statement: " . self::$connection->error;
        }
        $stmt->close();
        return $position;
    }

    protected static function deletePosition($data)
    {
        $sql = "DELETE FROM position WHERE position_id = ?";

        // Prepare the statement
        $stmt = self::$connection->prepare($sql);
        $position = [];
        if ($stmt) {
            // Bind parameters
            $stmt->bind_param("i", $data['data_id']);

            // Execute the statement
            $stmt->execute();

            // Check if any row was affected (deleted)
            if ($stmt->affected_rows > 0) {
                // Row was deleted successfully
                $position = [
                    'input_id' => $data['input_id'],
                    'data_id' => $data['data_id'],
                    'sequence' => $data['sequence'],
                    'value' => $data['value'],
                    'description' => $data['description']
                ];
            } else {
                // No rows were affected (no matching data_id found)

            }
        } else {
            // Error preparing statement
            echo "Error preparing statement: " . self::$connection->error;
        }
        $stmt->close();
        return $position;
    }


    protected static function getPositions()
    {
        self::$connection = DatabaseConnection::connect();

        $positions = [];

        // SQL query to select all positions
        $sql = "SELECT * FROM position";

        // Prepare and execute the statement
        $stmt = self::$connection->prepare($sql);

        if ($stmt) {
            $stmt->execute();

            $position_id =  $sequence = $title = $description = '';

            // Bind result variables
            $stmt->bind_result($position_id, $sequence, $title, $description);

            while ($stmt->fetch()) {
                $position = [
                    'input_id' => $position_id,
                    'data_id' => $position_id,
                    'sequence' => $sequence,
                    'value' => $title,
                    'description' => $description
                ];

                $positions[] = $position;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . self::$connection->error;
        }


        return $positions;
    }
}
