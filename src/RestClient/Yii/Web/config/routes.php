<?php

return [
    "GET rest" => "rest-client/project/index",
    "GET rest/<projectName>/<tag>" => "rest-client/request/send",
    "GET rest/<projectName>" => "rest-client/request/send",
    "POST rest/<projectName>" => "rest-client/request/send",
];