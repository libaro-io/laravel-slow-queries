__ideas for the future__


[+] also log guid/id for same request to slowQuery table
[+] also save queries without the params
[+] take a hash from the queries without the params (for easier grouping and handling of the same queries)
[+] refactor
[+] phpstan again
[+] detail page : 2 ways of sorting: by latest and by slowest
[+] use a sql prettifier package for better output on the detail page
[+] link to Libaro
[+] real data for gauge
[+] real data for treemap
[+] change units to ms (laten varieren , human readable )
[+] exclude routes
[+] button for easier copy the query (as in copy paste)
[+] bugfix : query with bindings : missing quotes
[+] prepare V1 : add intermediate level / temporary disable index features
[+] base class for data service
[+] selectable date range in admin pages


[-] add dashboard widgets
[+]     top x (eg 10, configurable) slowest pages
[+]     top x (eg 10, configurable) slowest queries
[-]     top x (eg 10, configurable) pages with too many queries (> x, configurable) (the n+1 problem)

[-] admin pages for
[+]     slowest pages
[+]     slowest queries
[-]     pages with too many queries
[-]     pages with duplicate queries




[-] more consistency in names (variables, package prefixes for tables, etc)
[-] query abbrevation on slow-queries index + detail : is now abbreviated with php => TODO: only abbreviate with css so the number of characters shown is ‘responsive‘ with the page width
[-] make registerRoutes, registerViews conditional (should ui admin pages also be disabled when the package is disabled?)
[-] retest button   (with transacties)
[-] command to automatically clean data older than x days (x days = configurable)
[-] also log queries that take to much data / MB
[-] filtering + sorting in admin pages
[-] button to open source file in your favorite IDE
[-] detect, analyse and suggest solutions for the laravel n+1 query problem
[-] bugfix : also parse and + or in where, etc  e.g. http://localhost:8000/slow-queries/queries/8
[-] use sticky headings (https://tailwindui.com/components/application-ui/lists/stacked-lists)

[-] trial-and-error indexes :
        create a list of possible missing indexes for a query
        foreach possible missing index, also loop the different combinations
                create that index
                run the query again (a few times)
                measure the timings
                delete the index again
        
        analyse for which combinations of generated indexes the query was fastest
        mark one of the index combinations as 'BEST' and suggest to create those indexes

[-] check for possible missing indexes, based on fields used for  
            WHERE
            GROUP BY
            JOIN
            ORDER BY
    next, suggest columns for which to create indexes on, based on hightest cost according to the explain analyze results 
    quick and dirty method :
    just check which columns are in the sql query for which indexes do not exist ?
