Data aggregation for street network
===================================

What does the algorithm currently do?
-------------------------------------

* Iterate over all OpenStreetMap road-coordinates within a defined bounding-box
* Download all tracks from enviroCar within a bounding-box
* Calculate the IDW for all measurements within a distance < 20m of a street
* Store the aggregated values within a PostGIS database
* Export as GeoJSON

Setup
-----

For the data aggregation, you will need a PostgreSQL database with PostGIS extension.

```
sudo apt-get install php5-pgsql
sudo apt-get install postgresql-9.1
sudo apt-get install postgresql-9.1-postgis
sudo apt-get install postgresql pgadmin3
``` 

The SQL files to create the tables can be found in the folder ``sql``.

As the aggregation is based on OpenStreetMap roads, you have to insert the roads for your preferred region. Download possible on: Geofabrik (http://download.geofabrik.de/, download as .shp files (route.shp)).

In addition to that, you have to create a config file ``db_conf.php`` with the server-credentials and the url based on the file ``db_conf-sample.php`` (the file with the actual credentials is ignored by GitHub to keep the password secret).

The file has to include:

```
$dbhost = 'YOUR_SERVER_URL';
$dbname = 'YOUR_DATABASE_NAME';
$dbuser = 'YOUR_USER_NAME';
$dbpw = 'YOUR_PASSWORD';
```

The algorithm can be started with the file ``data-aggregation-idw.php``.


Todo/Improvements
-----------------

* Distribute the caluclation in several threads (one for each road?)
* Load only measurements near the road segements instead of the complete track
* Pagination if there are more than 100 tracks
* Implement Kriging
* Add other phenomenons


For more information, contact: Dennis Wilhelm (d.wilhelm@uni-muenster.de) 