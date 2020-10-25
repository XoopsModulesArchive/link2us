CREATE TABLE link2us_master (
    id            INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    date_added    DATETIME,
    date_modified DATETIME,
    banner_id     VARCHAR(75)
);

CREATE TABLE link2us_banners (
    id            INT NOT NULL,
    master_id     INT NOT NULL,
    date_added    DATETIME,
    date_modified DATETIME,
    image_url     VARCHAR(150),
    click_url     VARCHAR(150)
);
 


