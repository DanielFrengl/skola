<?php
// Event.php (Model)
include 'Db.php';

class Event
{
    private $id;
    private $title;
    private $start;
    private $end;
    private $description;
    private $url;

    // Constructor for Event class
    public function __construct($title, $start, $end, $description = '', $url = '')
    {
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
        $this->description = $description;
        $this->url = $url;
    }

    // Get all events from the database
    public static function getAllEvents()
    {
        $query = "SELECT * FROM events ORDER BY start";
        return Db::dotazVsechny($query);
    }

    // Insert a new event into the database
    public function save()
    {
        $query = "INSERT INTO events (title, start, end, description, url) 
                  VALUES (:title, :start, :end, :description, :url)";

        $params = [
            ':title' => $this->title,
            ':start' => $this->start,
            ':end' => $this->end,
            ':description' => $this->description,
            ':url' => $this->url
        ];

        Db::dotaz($query, $params);
    }

    // Update an existing event in the database
    public static function update($id, $title, $start, $end, $description, $url)
    {
        $query = "UPDATE events SET title = :title, start = :start, end = :end, 
                  description = :description, url = :url WHERE id = :id";

        $params = [
            ':id' => $id,
            ':title' => $title,
            ':start' => $start,
            ':end' => $end,
            ':description' => $description,
            ':url' => $url
        ];

        Db::dotaz($query, $params);
    }

    // Delete an event from the database
    public static function delete($id)
    {
        $query = "DELETE FROM events WHERE id = :id";
        $params = [':id' => $id];
        Db::dotaz($query, $params);
    }
}
?>
