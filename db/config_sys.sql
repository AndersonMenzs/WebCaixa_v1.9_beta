CREATE TABLE IF NOT EXISTS config_sys (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dt_config DATE NOT NULL,
    cod_config CHAR(10) NOT NULL,
    vlr_config DECIMAL(7,2) NOT NULL,
    num_config CHAR(5) DEFAULT NULL,
    operador CHAR(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

insert into config_sys values('1', '2027-07-28', 'AGHATA', 0.00, '35', '00000359');
insert into config_sys values('2', '2027-07-28', 'SENIOR', 0.00, '55', '00000359');
insert into config_sys values('3', '2027-07-28', 'RECOLH', 300.00, '0', '00000359');
