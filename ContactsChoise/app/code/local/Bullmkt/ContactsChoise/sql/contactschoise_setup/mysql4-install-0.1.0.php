<?php
$installer = $this;
$installer->startSetup();
$installer->run("
    DROP TABLE IF EXISTS {$this->getTable('bullmkt_contactschoise_receiver')};
    CREATE TABLE {$this->getTable('bullmkt_contactschoise_receiver')} (
        `receiver_id` int(11) unsigned NOT NULL auto_increment,
        `receiver_name` varchar(255) NOT NULL default '',
        `receiver_email` varchar(255) NOT NULL default '',
        PRIMARY KEY (`receiver_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
$installer->endSetup();
?>

<script>
    alert('Banco Instalado');
</script>