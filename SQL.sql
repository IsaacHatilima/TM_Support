CREATE TABLE clients
(
    client_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    client_first_name VARCHAR(50) NOT NULL,
    client_last_name VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL,
    cell VARCHAR(15) NULL,
    bank_id_fk INT NOT NULL,
    contact_type INT NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified_by INT NULL,
    date_modified DATETIME NULL,
    modification_reason TEXT NULL 
);

CREATE TABLE user_login
(
    user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    person_id INT NOT NULL
    username VARCHAR(50) NOT NULL,
    password VARCHAR(150) not NULL,
    status INT NOT NULL,
    role VARCHAR(20) NOT NULL,
    last_login DATETIME NULL,
    ip_address VARCHAR(50) NULL,
    changed_password INT NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified INT NULL,
    date_modified DATETIME NULL
);

CREATE TABLE banks
(
    bank_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    bank_name VARCHAR(50) NOT NULL,
    bank_name_abbr VARCHAR(10) NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified_by INT NULL,
    date_modified DATETIME NULL
);

CREATE TABLE atm_details
(
    atm_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    atm_name VARCHAR(45) NOT NULL,
    atm_site VARCHAR(45) NOT NULL,
    atm_type VARCHAR(45) NOT NULL,
    atm_model VARCHAR(45) NOT NULL,
    bank_id_fk INT NOT NULL,
    serial_num VARCHAR(45) NOT NULL,
    zone_id_fk INT NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified_by INT NULL,
    date_modified DATETIME NULL
);

CREATE TABLE atm_call
(
    call_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    bank_id_fk INT NOT NULL,
    atm_id_fk INT NOT NULL,
    call_status VARCHAR(45) NOT NULL,
    logged_by INT NOT NULL,
    time_logged DATETIME NOT NULL,
    category_id_fk VARCHAR(45) NOT NULL,
    sub_category_id_fk VARCHAR(45) NOT NULL,
    fault_details TEXT NOT NULL,
    engineer_on_site INT NULL,
    solution TEXT NULL,
    close_time DATETIME NULL,
    resolution_time TIME NULL,
    custodian_name VARCHAR(45) NOT NULL,
    custodian_contact VARCHAR(15) NOT NULL,
    opened_by INT NULL,
    open_date DATETIME NULL,
    log_month VARCHAR(15) NOT NULL,
    log_year INT NOT NULL,
    reson_for_delay TEXT NULL,
    custodian_status TEXT NULL
 
);

CREATE TABLE engineers
(
    engineer_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    engineers_first_name VARCHAR(50) NOT NULL,
    engineers_last_name VARCHAR(50) NOT NULL,
    email VARCHAR(150) NOT NULL,
    cell VARCHAR(15) NULL,
    department VARCHAR(45) NOT NULL,
    display_image VARCHAR(100) NOT NULL,
    uuid VARCHAR(45) NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified_by INT NULL,
    date_modified DATETIME NULL
);

CREATE TABLE pos_calls
(
    pos_call_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    bank_id_fk INT NOT NULL,
    call_status VARCHAR(50) NOT NULL,
    mechant_type INT NOT NULL,
    mechant_name VARCHAR(50) NOT NULL,
    category_id_fk VARCHAR(50) NOT NULL,
    sub_category_id_fk VARCHAR(50) NOT NULL,
    third_level_category VARCHAR(100) NULL,
    site_location VARCHAR(50) NOT NULL,
    device_type VARCHAR(50) NOT NULL,
    urgency VARCHAR(50) NULL,
    contact_name VARCHAR(50) NULL,
    contact_cell VARCHAR(50) NULL,
    fault_details TEXT NOT NULL,
    solution TEXT NULL,
    repair_time VARCHAR(50) NULL,
    logged_by INT NOT NULL,
    date_logged DATE NOT NULL,
    time_logged VARCHAR (20) NOT NULL,
    closed_by INT NULL,
    time_closed VARCHAR(20) NULL, 
    date_closed DATE NULL,
    opened_by INT NULL,
    date_opened DATETIME NULL,
    impact_to_business TEXT NULL,
    call_priority VARCHAR(50) NULL,
    engineer_on_site VARCHAR(50) NULL,
    months VARCHAR(50) NOT NULL,
    years INT NOT NULL
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

CREATE TABLE atm_categories
(
    category_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(100) NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL
);

CREATE TABLE atm_sub_categories
(
    sub_category_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category_id_fk INT NOT NULL,
    sub_category VARCHAR(100) NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL
);

CREATE TABLE sla_times
(
    sla_time_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    bank_id_fk INT NOT NULL,
    resolution_time INT NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified_by INT NULL,
    date_modified DATETIME NULL
);

CREATE TABLE zones
(
    zone_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    zone_name VARCHAR(50) NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL,
    modified_by INT NULL,
    date_modified DATETIME NULL
);

CREATE TABLE email_list
(
    emailList_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    bank_id_fk INT NOT NULL,
    emailID VARCHAR(45) NOT NULL,
    created_by INT NOT NULL,
    date_created DATETIME NOT NULL
);
-- New Tables
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

CREATE TABLE device_info
(
    device_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    mechant_log_id_fk INT NOT NULL,
    device_type VARCHAR(100) NULL,
    terminal_id VARCHAR(100) NULL,
    device_serial VARCHAR(100) NULL,
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
CREATE TABLE sms_notifications
(
    sms_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cell INT NOT NULL,
    text_message VARCHAR(200) NOT NULL,
    local_date DATE NOT NULL,
    logdate DATETIME NOT NULL
);