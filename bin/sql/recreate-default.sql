DROP DATABASE IF EXISTS top_2000_v1;
DROP DATABASE IF EXISTS top_2000_v2;
DROP DATABASE IF EXISTS weerstations;
DROP DATABASE IF EXISTS postcode;

CREATE DATABASE top_2000_v1;
CREATE DATABASE top_2000_v2;
CREATE DATABASE weerstations;
CREATE DATABASE postcode;

USE top_2000_v1;
\. /workspace/PHPMySQL_fork/bin/sql/top_2000_v1.sql

USE weerstations;
\. /workspace/PHPMySQL_fork/bin/sql/weerstations.sql

USE top_2000_v2;
\. /workspace/PHPMySQL_fork/bin/sql/top_2000_v2.sql

USE postcode;
\. /workspace/PHPMySQL_fork/bin/sql/postcode.sql
