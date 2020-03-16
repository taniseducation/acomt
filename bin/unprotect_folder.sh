# Files: rwx for user
sudo find /home/ubuntu/workspace/bin -type f -exec chmod 755 {} \;
# Folders
sudo find /home/ubuntu/workspace/bin -type d -exec chmod 755 {} \;
