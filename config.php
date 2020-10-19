<?php
/* MANDATORY */
defined("DB_HOST") || define("DB_HOST", "");
defined("DB_USERNAME") || define("DB_USERNAME", "");
defined("DB_NAME") || define("DB_NAME", "");
defined("DB_PASSWORD") || define("DB_PASSWORD", "");
defined("DB_TABLE") || define("DB_TABLE", "");

defined("MAILER_HOST") || define("MAILER_HOST", "");
defined("MAILER_PORT") || define("MAILER_PORT", 465);
defined("MAILER_USERNAME") || define("MAILER_USERNAME", "");
defined("MAILER_PASSWORD") || define("MAILER_PASSWORD", "");
defined("MAILER_SENDER_MAIL") || define("MAILER_SENDER_MAIL", "");
defined("MAILER_SENDER_NAME") || define("MAILER_SENDER_NAME", "");
defined("MAILER_RECIPIENT_MAIL_DOMAIN") || define("MAILER_RECIPIENT_MAIL_DOMAIN", "");
defined("MAILER_SUBJECT") || define("MAILER_SUBJECT", "");

/* NOT MANDATORY */
defined("MAIL_PARAM_ARRAY") || define("MAIL_PARAM_ARRAY",
    array(
        "sender-name" => MAILER_SENDER_NAME,
        "sender-mail" => MAILER_SENDER_MAIL,
    )
);
