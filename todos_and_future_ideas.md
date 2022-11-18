__ideas for the future__

[-] more consistency in names (variables, package prefixes for tables, etc)

[-] also log guid/id for same request to slowQuery table

[-] filtering + sorting in admin pages

[-] add dashboard widgets
        top x (eg 10, configurable) slowest pages
        top x (eg 10, configurable) slowest queries
        top x (eg 10, configurable) pages with too many queries (> x, configurable) (the n+1 problem)

[-] admin pages for
        slowest pages
        slowest queries
        pages with too many queries
        pages with duplicate queries

                

[-] also log queries that take to much data / MB

[x] also save queries without the params

[x] take a hash from the queries without the params (for easier grouping and handling of the same queries)

[-] button for easier copy the query (as in copy paste)

[-] button to open source file in your favorite IDE

[-] detect, analyse and suggest solutions for the laravel n+1 query problem 

[-] trial-and-error indexes :
        create a list of possible missing indexes for a query
        foreach possible missing index, also loop the different combinations
                create that index
                run the query again (a few times)
                measure the timings
                delete the index again
        
        analyse for which combinations of generated indexes the query was fastest
        mark one of the index combinations as 'BEST' and suggest to create those indexes





[-] command to automatically clean data older than x days (x days = configurable)

[-] use a sql prettifier package for better output on the detail page

[-] check for possible missing indexes, based on fields used for  
        WHERE
        GROUP BY
        JOIN
        ORDER BY
next, suggest columns for which to create indexes on, based on hightest cost according to the explain analyze results


quick and dirty method :
just check which columns are in the sql query for which indexes do not exist ?





[-] bugfix : query
select
`permissions`.*,
`model_has_permissions`.`model_id` as `pivot_model_id`,
`model_has_permissions`.`permission_id` as `pivot_permission_id`,
`model_has_permissions`.`model_type` as `pivot_model_type`
from
`permissions`
inner join `model_has_permissions` on `permissions`.`id` = `model_has_permissions`.`permission_id`
where
`model_has_permissions`.`model_id` in (1)
and `model_has_permissions`.`model_type` = App\Domains\Auth\Models\User

should be saved as this instead: (notice the missing single quotes)
select
`permissions`.*,
`model_has_permissions`.`model_id` as `pivot_model_id`,
`model_has_permissions`.`permission_id` as `pivot_permission_id`,
`model_has_permissions`.`model_type` as `pivot_model_type`
from
`permissions`
inner join `model_has_permissions` on `permissions`.`id` = `model_has_permissions`.`permission_id`
where
`model_has_permissions`.`model_id` in (1)
and `model_has_permissions`.`model_type` = 'App\Domains\Auth\Models\User'


[-] bugfix : also parse and + or in where, etc 
e.g. http://localhost:8000/slow-queries/queries/8

