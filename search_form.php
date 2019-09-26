<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PHP Live MySQL Database Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="search_form.css">

    <script type="text/javascript">

        function setActions(originalThis) {
            /* Get input value on change */
            var inputVal = $('#searchText').val();

            /* Get selected search type on change */
            var searchType = $('#searchTypeSelect :selected').val();

            var resultDropdown = $(originalThis).siblings(".result"); // sibling in same container as this element
            if (inputVal.length) {
                $.get("backend_search.php", {
                    term: inputVal,
                    searchType: searchType
                }).done(function(data) {
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else {
                resultDropdown.empty();
            }
        }

        $(document).ready(function() {
            $('.search-box #searchText').on("keyup input", function() {
                setActions(this);
            });

            $('.search-box #searchTypeSelect').on("change", function() {
                setActions(this);
            });

            // Set search input value on click of result item
            $(document).on("click", ".result p", function() {
                $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
                $(this).parent(".result").empty();
            });
        });
    </script>
</head>

<body>
    <div class="search-box">
        <input id="searchText" type="text" autocomplete="off" placeholder="Search country..." />
        <select id="searchTypeSelect">
            <option value="any">Any</option>
            <option value="exact">Exact</option>
            <option value="starting">Starting with</option>
            <option value="ending">Ending with</option>
        </select>
        <div class="result"></div>
    </div>
</body>

</html>

<!-- 
Table characteristics:
CREATE TABLE countries (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL
); 
-->

<!-- 
Table contents:
INSERT INTO `countries` (`id`, `name`) VALUES
(1, 'Afghanistan'),
(2, 'Albania'),
...
(127, 'Yemen'),
(128, 'Zambia'),
(129, 'Zimbabwe'); 
-->