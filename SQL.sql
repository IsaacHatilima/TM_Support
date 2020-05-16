CREATE TABLE client_users
(
    client_user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    client_user_first_name VARCHAR(50) NOT NULL,
    client_user_last_name VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL,
    cell VARCHAR(15) NULL,
    client_id_fk INT NOT NULL,
    contact_type VARCHAR(50) NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified_by INT NULL,
    date_modified DATETIME NULL,
    modification_reason TEXT NULL 
);

CREATE TABLE client_login
(
    user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    person_id INT NOT NULL,
    emails VARCHAR(50) NOT NULL,
    password VARCHAR(150) not NULL,
    status VARCHAR(150) NOT NULL,
    role VARCHAR(20) NOT NULL,
    last_login DATETIME NULL,
    changed_password INT NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified INT NULL,
    date_modified DATETIME NULL
);

CREATE TABLE clients
(
    client_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    client_name VARCHAR(50) NOT NULL,
    client_name_abbr VARCHAR(10) NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified_by INT NULL,
    date_modified DATETIME NULL
);

CREATE TABLE email_notifications
(
    notification_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    email_type VARCHAR(10) NOT NULL,
    email_addres VARCHAR(150) NOT NULL,
    email_status VARCHAR(50) NOT NULL,
    email_subject VARCHAR(50) NOT NULL,
    email_message TEXT NOT NULL,
    local_date DATE NOT NULL,
    logdate DATETIME NOT NULL,
    send_count INT NOT NULL,
    bankID INT NOT NULL
);

CREATE TABLE engineers
(
    engineer_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    engineer_first_name VARCHAR(50) NOT NULL,
    engineer_last_name VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL,
    cell VARCHAR(15) NULL,
    department VARCHAR(15) NULL,
    uuid VARCHAR(15) NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified_by INT NULL,
    date_modified DATETIME NULL,
);

CREATE TABLE engineer_login
(
    engineer_user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    tech_id INT NOT NULL,
    engineer_email VARCHAR(50) NOT NULL,
    engineer_passcode VARCHAR(150) not NULL,
    engineer_status INT NOT NULL,
    engineer_role VARCHAR(20) NOT NULL,
    engineer_last_login DATETIME NULL,
    changed_password INT NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified INT NULL,
    date_modified DATETIME NULL
);

CREATE TABLE device_info
(
    device_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    mechant_log_id_fk INT NOT NULL,
    device_type VARCHAR(100) NULL,
    terminal_id VARCHAR(100) NULL,
    device_serial VARCHAR(100) NULL,
    ptid VARCHAR(100) NULL,
    base_serial VARCHAR(100) NULL,
    mtn_sim_serial VARCHAR(100) NULL,
    airtel_sim_serial VARCHAR(100) NULL,
    installation_date VARCHAR(100) NULL,
    ip_address VARCHAR(100) NULL,
    fnb_asset_code VARCHAR(100) NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL
);

CREATE TABLE pos_categories
(
    category_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL
);

INSERT INTO pos_categories
  ( category, created_by, date_created )
VALUES
  ('Hardware', 1, '2020-04-16 12:02:22'), 
  ('Software', 1, '2020-04-16 12:02:22'), 
  ('Infrastructure', 1, '2020-04-16 12:02:22'),
  ('Installation', 1, '2020-04-16 12:02:22'),
  ('Stationary', 1, '2020-04-16 12:02:22'),
  ('Connectivity', 1, '2020-04-16 12:02:22');


CREATE TABLE pos_sub_categories
(
    sub_category_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category_id_fk INT NOT NULL,
    sub_category VARCHAR(100) NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL
);

CREATE TABLE pos_primary_contact
(
    pos_primary_contact INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    available INT NOT NULL,
    banks INT NOT NULL
);

CREATE TABLE mechants
(
    mechant_log_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    mechant_type VARCHAR(100) NOT NULL,
    mechant_name VARCHAR(100) NOT NULL,
    mechant_id VARCHAR(100) NOT NULL,
    mechant_province VARCHAR(100) NOT NULL,
    mechant_town VARCHAR(100) NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL
);

CREATE TABLE sms_notifications
(
    sms_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cell INT NOT NULL,
    text_message VARCHAR(200) NOT NULL,
    local_date DATE NOT NULL,
    logdate DATETIME NOT NULL
);

CREATE TABLE device_repair
(
    repair_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    device_type VARCHAR[200] NOT NULL,
    device_serial VARCHAR(200) NOT NULL,
    ptid VARCHAR(200) NOT NULL,
    warrant_sticker VARCHAR(200) NOT NULL,
    fault_on_screen VARCHAR(200) NOT NULL,
    general_problem VARCHAR(200) NOT NULL,
    parts_used VARCHAR(200) NOT NULL,
    eos_reload VARCHAR(200) NOT NULL,
    date_repaired VARCHAR(200) NOT NULL,
    final_test VARCHAR(200) NOT NULL,
    status_comment VARCHAR(200) NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL
);

CREATE TABLE pos_device_calls
(
    device_call_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ticket_number INT NULL,
    call_priority VARCHAR(45) NOT NULL,
    devcall_mechant_log_id_fk VARCHAR(45) NOT NULL,
    call_device_serial VARCHAR(45) NULL,
    category_id_fk INT NOT NULL,
    sub_category_id_fk INT NOT NULL,
    fault_details VARCHAR(45) NOT NULL,
    solution TEXT NULL,
    managers_name VARCHAR(45) NOT NULL,
    managers_cell VARCHAR(45) NOT NULL,
    logged_by VARCHAR(45) NOT NULL,
    date_loged DATETIME NOT NULL,
    closed_by VARCHAR(45) NULL,
    date_closed DATETIME NULL,
    repair_time VARCHAR(50) NULL,
    sla_status VARCHAR(45) NULL,
    escalated INT NULL,
    escalated_to VARCHAR(150) NULL,
    device_call_status VARCHAR(150) NULL,
    call_month VARCHAR(50) NOT NULL,
    call_year VARCHAR(50) NOT NULL,
    engineer_idz INT NULL,
    mecha_type VARCHAR(45) NOT NULL,
    device_qota INT NOT NULL,
    clientID INT NOT NULL
);

CREATE TABLE pos_delivery_calls
(
    delivery_call_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ticket_number INT NULL,
    delivery_call_priority VARCHAR(45) NOT NULL,
    delivery_mechant_log_id_fk VARCHAR(45) NOT NULL,
    delivery_category_id_fk INT NOT NULL,
    delivery_sub_category_id_fk INT NOT NULL,
    item_to_deliver VARCHAR(45) NOT NULL,
    solution TEXT NULL,
    delivery_managers_name VARCHAR(45) NOT NULL,
    delivery_managers_cell VARCHAR(45) NOT NULL,
    delivery_logged_by VARCHAR(45) NOT NULL,
    delivery_date_loged DATETIME NOT NULL,
    delivery_closed_by VARCHAR(45) NULL,
    delivery_date_closed DATETIME NULL,
    resolution_time VARCHAR(50) NULL,
    delivery_sla_status VARCHAR(45) NULL,
    delivery_escalated INT NULL,
    delivery_escalated_to VARCHAR(150) NULL,
    delivery_call_status VARCHAR(150) NULL,
    delivery_call_month VARCHAR(50) NOT NULL,
    delivery_call_year VARCHAR(50) NOT NULL,
    delivery_engineer_idz INT NULL
    mech_type VARCHAR(45) NOT NULL,
    delivery_qota INT NOT NULL,
    clientID INT NOT NULL
);

CREATE TABLE ticket_numbers
(
    tik_num INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    ticket_number INT NULL
);

INSERT INTO ticket_numbers (ticket_number) VALUES ('0');