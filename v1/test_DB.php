<?php
$host = "localhost";
$database = "api_db";
$user = "postgres";
$password = "root";


// Initialize connection object.
$connection = pg_connect("host=$host user=$user password=$password")
or die("Failed to create connection to database: ". pg_last_error(). "\n");
print "Successfully created connection to database.\n";

// Create db.
$query = "SELECT EXISTS(SELECT datname FROM pg_catalog.pg_database WHERE datname = 'api_db');";

$result = pg_query($connection, $query);

$result = pg_fetch_assoc($result);

if ($result['exists'] == 'f'){

	$query = "CREATE DATABASE api_db;";

	print "Waiting to creating database ... \n";

	pg_query($connection, $query)
	or die("Encountered an error when executing given sql statement: ". pg_last_error(). "\n");
	print "Finished creating database: 'api_db'. \n";
}else
	print "'api_db' all ready exists. \n";

pg_close($connection);

$connection = pg_connect("host=$host dbname=$database user=$user password=$password")
or die("Failed to create connection to database: ". pg_last_error(). "\n");
print "Successfully created connection to database 'api_db.\n";

// Create table.
$query = "CREATE TABLE IF NOT EXISTS api (api_key VARCHAR(255) PRIMARY KEY, client_id INTEGER);";
pg_query($connection, $query)
or die("Encountered an error when executing given sql statement: ". pg_last_error(). "\n");
print "Finished creating table: api.\n";

// Insert some data into table.
$api_key = '\'7dbb8d6e\'';
$client_id = 521;
$query = "INSERT INTO api (api_key, client_id) VALUES ($api_key, $client_id);";
pg_query($connection, $query)
or die("Encountered an error when executing given sql statement: ". pg_last_error(). "\n");

$api_key = '\'b1339024\'';
$client_id = 1452;
$query = "INSERT INTO api (api_key, client_id) VALUES ($api_key, $client_id);";
pg_query($connection, $query)
or die("Encountered an error when executing given sql statement: ". pg_last_error(). "\n");

$api_key = '\'2cb6c608\'';
$client_id = 6332;
$query = "INSERT INTO api (api_key, client_id) VALUES ($api_key, $client_id);";
pg_query($connection, $query)
or die("Encountered an error when executing given sql statement: ". pg_last_error(). "\n");

$api_key = '\'d774c95c\'';
$client_id = 6923;
$query = "INSERT INTO api (api_key, client_id) VALUES ($api_key, $client_id);";
pg_query($connection, $query)
or die("Encountered an error when executing given sql statement: ". pg_last_error(). "\n");

print ("Created some test api-key and client-id.\n
api_key: 7dbb8d6e
clint-id: 521\n
api_key: b1339024
clint-id: 1452\n
api_key: 2cb6c608
clint-id: 6332\n
api_key: d774c95c
clint-id: 6923\n");

// Create table.
$query = "CREATE TABLE IF NOT EXISTS delivery (order_date_create DATE NOT NULL,
 												order_delivery DATE NOT NULL, 
 												product_id INTEGER NOT NULL, 
 												destination VARCHAR (255), 
 												order_id SERIAL PRIMARY KEY);";
pg_query($connection, $query)
or die("Encountered an error when executing given sql statement: ". pg_last_error(). "\n");
print("Finished creating table: delivery.\n");

// Create table.
$query = "CREATE TABLE IF NOT EXISTS products (description VARCHAR (255), 
												name VARCHAR (255) NOT NULL, 
												sku  VARCHAR (255) UNIQUE, 
												vendor  VARCHAR (255), 
												images  VARCHAR (255), 
												price numeric, 
												height INTEGER, 
												width INTEGER, 
												weight INTEGER, 
												product_id SERIAL PRIMARY KEY);";
pg_query($connection, $query)
or die("Encountered an error when executing given sql statement: ". pg_last_error(). "\n");
print("Finished creating table: products.\n");

// Insert some data into table.
$query = "INSERT INTO products (description, 
								name,
								sku,
								vendor,
								images,
								price,
								height,
								width,
								weight) 
						VALUES ('Смартфон',
								'Смартфон Apple iPhone XS 256GB Space Grey',
								'147190464',
								'Apple, Inc', 
								'https://ozon-st.cdn.ngenix.net/multimedia/1024351473.jpg',
								'100990',
								'80',
								'160',
								'240'),
								('Red Samsung Galaxy S9 with 512GB',
								'Samsung Galaxy S9',
								'14711d464',
								'Samsung', 
								'https://ozon-st.cdn.ngenix.net/multimedia/c1200/1022555115.jpg',
								'79990',
								'77',
								'120',
								'120'),
								('Black Samsung Galaxy M31 with 128GB',
								'Samsung Galaxy M31',
								'5722937',
								'Samsung', 
								'',
								'19990',
								'90',
								'160',
								'200');";
pg_query($connection, $query)
or die("Encountered an error when executing given sql statement: ". pg_last_error(). "\n");

// Closing connection
pg_close($connection);