<?php
//queries used by tests
return array(
    'chamados' => array(
        'create' => 'CREATE TABLE IF NOT EXISTS chamados (
                    id INT NOT NULL AUTO_INCREMENT,
                    numero VARCHAR(14) NOT NULL,
                    chamado_cobra VARCHAR(15) NOT NULL,
                    dependencia VARCHAR(70) NOT NULL,
                    dtachamado DATETIME NOT NULL,
                    dtalimite DATETIME NOT NULL,
                    status VARCHAR(20) NOT NULL,
                    tecnico_alocado VARCHAR(50) NULL,
                    agencia VARCHAR(4) NOT NULL,
                    nrocontrato VARCHAR(13) NOT NULL,
                    grupo VARCHAR(5) NOT NULL,
                    observacao VARCHAR(100) NULL,
                    PRIMARY KEY (id))
                    ENGINE = InnoDB;',
        'drop' => 'DROP TABLE chamados;'
    ),
);
