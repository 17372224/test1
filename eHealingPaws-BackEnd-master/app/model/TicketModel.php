<?php

use BunnyPHP\Model;

class TicketModel extends Model
{

    public function createTicket($content, $zoneId)
    {
        return $this->add([
            'ticket_user' => $_SESSION['userId'],
            'ticket_content' => $content,
            'ticket_zone' => $zoneId,
            'ticket_status' => 0
        ]);
    }

    public function getTicket($ticketId)
    {
        return $this->where('ticket_id = :t', ['t' => $ticketId])->fetch();
    }

    /**
     * @param $page integer Default = 1
     * @param $limit integer Default = 20
     * @param $zoneId integer|null Specify the zone or not.
     * @return array Array of tickets
     */
    public function getAllTickets($page, $limit, $zoneId)
    {
        if (empty($zoneId)) {
            // fetch all
            if ($_SESSION['authority'] == 'user') {
                return $this->where('ticket_user = :u', ['u' => $_SESSION['userId']])
                    ->limit($limit, ($page - 1) * $limit)
                    ->fetchAll();
            } else {
                return $this->limit($limit, ($page - 1) * $limit)->fetchAll();
            }
        } else {
            // fetch specified zone
            if ($_SESSION['authority'] == 'user') {
                return $this->where('ticket_user = :u and ticket_zone = :t', ['u' => $_SESSION['userId'], 't' => $zoneId])
                    ->limit($limit, ($page - 1) * $limit)
                    ->fetchAll();
            } else {
                return $this->where('ticket_zone = :t', ['t' => $zoneId])
                    ->limit($limit, ($page - 1) * $limit)
                    ->fetchAll();
            }
        }
    }

    /**
     * @param $ticketId int Ticket id.
     * @param $status int Ticket status.
     * @return int|string Returns 0 if update failed.
     */
    public function updateStatus($ticketId, $status)
    {
        // todo: 权限控制
        return $this->where('ticket_id = :t', ['t' => $ticketId])
            ->update(['ticket_status' => $status]);
    }
}
