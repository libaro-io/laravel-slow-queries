__ideas for the future__

[-] also log guid/id for same request to slowQuery table

[-] also log queries that take to much data / MB

[x] also save queries without the params

[x] take a hash from the queries without the params (for easier grouping and handling of the same queries)

[-] button for easier copy the query (as in copy paste)

[-] button to open source file in your favorite IDE  

[-] command to automatically clean data older than x days (x days = configurable)  

[-] check for possible missing indexes, based on fields used for  
        WHERE
        GROUP BY
        JOIN
        ORDER BY

next, suggest columns for which to create indexes on, based on hightest cost according to the explain analyze results


quick and dirty method :
just check which columns are in the sql query for which indexes do not exist ?



