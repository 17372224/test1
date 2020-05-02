<?php

use BunnyPHP\Controller;

class TicketController extends Controller
{

    /**
     * @filter login
     *
     * @param $content string The json format of the ticket payload.
     * @param $zoneId integer Zone id for service location.
     */
    public function ac_create_post($content, $zoneId)
    {
        if (!empty($content) && !empty($zoneId)) {
            if ((new TicketModel())->createTicket($content, $zoneId)) {
                $this->assignAll(['message' => 'info.ticket.create.successful', 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway'])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter login
     *
     * @param $page integer Page number of the results.
     * @param $limit integer Number of rows for the results.
     * @param $zoneId integer|null specify the zoneId or get all area's tickets
     */
    public function ac_all_post($page, $limit, $zoneId)
    {
        if (empty($page))
            $page = 1;
        if (empty($limit))
            $limit = 20;

        if (empty($zoneId) || is_integer($zoneId)) {
            $data = (new TicketModel())->getAllTickets($page, $limit, $zoneId);
            if ($data) {
                $this->assignAll(['message' => 'info.ticket.get.successful', 'data' => $data, 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }
    }

    /**
     * @filter login
     */
    public function other()
    {
        $ticketId = $this->getAction();
        if (is_numeric($ticketId)) {
            $data = (new TicketModel())->getTicket($ticketId);
            if (!empty($data)) {
                $this->assignAll(['message' => 'info.ticket.get.successful', 'data' => $data, 'code' => 200])->render();
            } else {
                $this->assignAll(['message' => 'info.request.badGateway', 'code' => 502])->render();
            }
        } else {
            $this->assignAll(['message' => 'info.request.bad', 'code' => 400])->render();
        }
    }

}
