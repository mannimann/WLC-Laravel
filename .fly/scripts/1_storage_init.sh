# FOLDER=/var/www/html/storage/app
# if [ ! -d "$FOLDER" ]; then
#     echo "$FOLDER is not a directory, copying storage_ content to storage"
#     cp -r /var/www/html/storage_/. /var/www/html/storage
#     echo "deleting storage_..."
#     rm -rf /var/www/html/storage_
# fi


#  ggf. alles außer mkdir und touch ausklammern -> bei Problem: read-only DBy
FOLDER=/var/www/html/database/database
if [ ! -d "$FOLDER" ]; then
    echo "$FOLDER is not a directory, initializing database" 
    mkdir /var/www/html/database/database
    touch /var/www/html/database/database/database.sqlite
fi
