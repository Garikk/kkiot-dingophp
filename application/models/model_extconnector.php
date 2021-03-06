<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_kkcontroller
 *
 * @author Garikk
 */
class model_extconnector extends Model {

    function __construct() {
        $this->dbc = new dbconnection();
    }

    public function get_pinmessages($MyID) {
        $ReqTS = time();

        $MyID = '2e2efd7b-ab83-42fa-9c00-2e45bb4b3ba1';

        $Ret = $this->dbc->ExecQuery(
                "UPDATE "
                . "   extconnector "
                . "   SET "
                . "    status=false "
                . "  WHERE "
                . "     direction=1 "
                . "     AND "
                . "     kkiot_id = "
                . "     (SELECT "
                . "         kkiot.id "
                . "      FROM "
                . "         kkiot "
                . "      WHERE "
                . "         kkiot.uuid='".$MyID."')"
                . "   AND "
                . "   timestamp<=".$ReqTS.""
                . "    AND"
                . "   status=true "
                . " RETURNING "
                . "  pinmessage, "
                . "    pinid, "
                . "    kkiot_id, "
                . "    status");



        return $Ret;
    }
    public function put_pinmessages($MyID, $direction,$pinid,$pindata) {
        $ReqTS = time();

        $MyID = '2e2efd7b-ab83-42fa-9c00-2e45bb4b3ba1';

        $Ret = $this->dbc->ExecQuery(
                "INSERT INTO"
                . "   extconnector "
                . "   ( "
                . "     timestamp, "
                . "     direction,"
                . "     pinid,"
                . "     pindata,"
                . "     status"
                . "     kkiot_conf_id"
                . "    ) "
                . "     VALUES ("
                . "    ". $ReqTS .","
                . "    ". $direction .","
                . "    ". $pinid .","
                . "    ". $pinid .","
                . "    true,"
                . "    (SELECT "
                . "         kkiot.activeconfiguration "
                . "      FROM "
                . "         kkiot "
                . "      WHERE "
                . "         kkiot.uuid='".$MyID."')"
                . "    ) ");

        return $Ret;
    }
}
