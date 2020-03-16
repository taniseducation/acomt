# Files: readonly
sudo find /home/ubuntu/workspace/bin -type f -exec chmod 555 {} \;
# Files in log folder: writable
sudo find /home/ubuntu/workspace/bin/log -type f -exec chmod 755 {} \;
# Folders
sudo find /home/ubuntu/workspace/bin -type d -exec chmod 755 {} \;
