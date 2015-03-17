# flickrgal
This is a sample flickr gallery which allows the user to search for photos using keywords/s. The gallery loads 5 images per page and allows the user to navigate between pages.

####Pagination Issue
The flickr API call has been implemented using 500 page size. There are two reasons behind it.
1. The flickr API does not behave correctly past 10000 pages. With per_page value of 5, most of the searches will have more than 10000 pages returned.
2. The application caches every 500 records of data so once a page is loaded, next 100 pages are returned immediately minimizing the number of API calls.

####Business and Presentation
This application has a clear seperation between business logic and view files. However, there are certain cases where the view files has some logics written which could have been moved to the controller but given the size and simplicity of the overall task, the current implemention makes more sense.

####Last Page
On a few occasisons, the total items returned by the flickr API does not match the total count they provide. A fix has been put in place in order to prevent broken pagination.

####Security and CSRF
Given the simplicity of the project, I have not included any CSRF checks. However, basic form security is in place which prevents the users from putting malicious entries like HTML, Quotes etc within the search box.

