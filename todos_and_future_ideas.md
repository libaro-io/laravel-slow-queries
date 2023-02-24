__ideas for the future__

[-] more consistency in names (variables, package prefixes for tables, etc)

[+] also log guid/id for same request to slowQuery table

[-] filtering + sorting in admin pages

[-] add dashboard widgets
[+]     top x (eg 10, configurable) slowest pages
[+]     top x (eg 10, configurable) slowest queries
[-]     top x (eg 10, configurable) pages with too many queries (> x, configurable) (the n+1 problem)

[-] admin pages for
[-]     slowest pages
[+]     slowest queries
[-]     pages with too many queries
[-]     pages with duplicate queries

                

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

[+] use a sql prettifier package for better output on the detail page

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


[-] realtime data for gauge
[-] real data for treemap

[-] refactor
[-] base class for data service

[-] phpstan again

[-] make registerRoutes, registerViews conditional


[-] op detail pagina : 2 manieren van sorteren mogelijk : zowel chronologisch als op traagste 
[-] eenheden aanpassen (laten varieren , human readable ) 
[-] retest knop   (met transacties) 
[-] paden excluden
[-] paden excluden


[-] naar V1 toewerken : tussenpagina voorzien / logica van index efkes disablen

[x] link naar Libaro






add option to choose ordering of slow queries occurences list : by chronological or by slowest 
<span class="isolate inline-flex rounded-md shadow-sm">
  <button type="button" class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">Years</button>
  <button type="button" class="relative -ml-px inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">Months</button>
  <button type="button" class="relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">Days</button>
</span>

+ use sticky headings (https://tailwindui.com/components/application-ui/lists/stacked-lists)
=> so the list is grouped by:

1 day ago
-item1
-item2
-item3

2 days ago
- item4
- -item5

1 week ago
- etc

or when by slowest:

very slow
- 5000 ms
- 6000 ms

slow
- 3000 ms




bugfix:
the same queries could be executed on different pages
this could be problematic when view the grouped results (slowQueryAggregation)
possible solution: add uri to the hash of the query_hashed


query abbrevation on slow-queries index + detail : is now abbreviated with php => TODO: only abbreviate with css so the number of characters shown is ‘responsive‘ with the page width
