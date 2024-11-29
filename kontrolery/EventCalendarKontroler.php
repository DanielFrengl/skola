<?php

require_once __DIR__ . '/../modely/Db.php';

class EventCalendarKontroler extends Kontroler
{
    // Method to handle displaying all events
    public function zpracuj(array $parametry): void
    {
        // Fetch all events from the database
        $sql = "SELECT * FROM events ORDER BY start";
        $events = Db::dotazVsechny($sql);

        // Prepare data for the view
        $this->data['events'] = $events;

        // Set the header data
        $this->hlavicka['titulek'] = 'All Events';
        $this->hlavicka['popis'] = 'List of all calendar events';
        $this->hlavicka['klicova_slova'] = 'events, calendar';

        // Set the view to render
        $this->pohled = 'calendar'; // Ensure this view exists at pohledy/calendar.phtml
    }

    public function getEvents()
    {
        $sql = "SELECT * FROM events ORDER BY start";
        $events = Db::dotazVsechny($sql);

        // Format events as an array of objects for FullCalendar
        $formattedEvents = [];
        foreach ($events as $event) {
            $formattedEvents[] = [
                'id' => $event['id'],
                'title' => $event['title'],
                'start' => $event['start'],
                'end' => $event['end'],
                'description' => $event['description'],
                'url' => '/event/details?id=' . $event['id'] // Optional: add a link to event details
            ];
        }

        // Return the events as JSON
        header('Content-Type: application/json');
        echo json_encode($formattedEvents);
        exit;
    }

    // Method to handle adding a new event
    public function addEvent()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve POST data
            $title = $_POST['title'];
            $start = $_POST['start'];
            $end = $_POST['end'];

            // Insert the event into the database
            $sql = "INSERT INTO events (title, start, end) VALUES (?, ?, ?)";
            Db::dotaz($sql, [$title, $start, $end]);

            // Redirect to the event list after successful insertion
            header('Location: /event/getAll');
            exit;
        }

        // Set the header data for adding an event
        $this->hlavicka['titulek'] = 'Add Event';
        $this->hlavicka['popis'] = 'Create a new calendar event';
        $this->hlavicka['klicova_slova'] = 'add, event';

        // Set the view to render for adding an event
        $this->pohled = 'event/add.phtml'; // Ensure this view exists at pohledy/event/add.phtml
    }

    // Method to handle updating an event
    public function updateEvent()
    {
        // Retrieve the event id from the query string
        $id = $_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve the updated POST data
            $title = $_POST['title'];
            $start = $_POST['start'];
            $end = $_POST['end'];

            // Update the event in the database
            $sql = "UPDATE events SET title = ?, start = ?, end = ? WHERE id = ?";
            Db::dotaz($sql, [$title, $start, $end, $id]);

            // Redirect to the event list after successful update
            header('Location: /event/getAll');
            exit;
        }

        // Fetch the event to edit
        $sql = "SELECT * FROM events WHERE id = ?";
        $event = Db::dotazJeden($sql, [$id]);

        // Pass the event data to the view
        $this->data['event'] = $event;

        // Set the header data for updating the event
        $this->hlavicka['titulek'] = 'Update Event';
        $this->hlavicka['popis'] = 'Edit the details of an event';
        $this->hlavicka['klicova_slova'] = 'update, event';

        // Set the view to render for updating an event
        $this->pohled = 'event/update'; // Ensure this view exists at pohledy/event/update.phtml
    }

    // Method to handle deleting an event
    public function deleteEvent()
    {
        // Retrieve the event id from the query string
        $id = $_GET['id'];

        // Delete the event from the database
        $sql = "DELETE FROM events WHERE id = ?";
        Db::dotaz($sql, [$id]);

        // Redirect to the event list after deletion
        header('Location: /event/getAll');
        exit;
    }
}
