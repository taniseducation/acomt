cat /workspace/csg_if_databases/bin/sql/recreate-project.sql | mysql
if [ -e /workspace/csg_if_databases/project_sql/project.sql ]; then
	cat /workspace/csg_if_databases/project_sql/project.sql | mysql -D project
fi

