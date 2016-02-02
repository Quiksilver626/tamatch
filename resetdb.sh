#!/bin/sh
echo ".dump" | sqlite3 tamatch.db > tamatch.txt
rm -f tamatch.db
cat tamatch.txt | sqlite3 tamatch.db
sudo chown -R www-data:www-data tamatch.db
