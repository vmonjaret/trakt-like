import $ from 'jquery';
import Routing from "./routing";

// Like movies
$('.addToFavorite').click(function (e) {
    e.stopPropagation();
    var movieId = $(this).attr('data-movieId');
    $.ajax({
        url: Routing.generate('movie_like'),
        type: "POST",
        dataType: "json",
        data: {
            "movieId": movieId
        },
        success: function () {
            $(e.target).toggleClass('active');
        }
    });
});

// Watch movies
$('.addToWatched').click(function (e) {
    e.stopPropagation();
    var movieId = $(this).attr('data-movieId');
    $.ajax({
        url: Routing.generate('movie_watched'),
        type: "POST",
        dataType: "json",
        data: {
            "movieId": movieId
        },
        success: function () {
            $(e.target).toggleClass('active');
        }
    });
});

// Wish movies
$('.addToWishList').click(function (e) {
    e.stopPropagation();
    var movieId = $(this).attr('data-movieId');
    $.ajax({
        url:Routing.generate('movie_wish'),
        type: "POST",
        dataType: "json",
        data: {
            "movieId": movieId
        },
        success: function () {
            $(e.target).toggleClass('active');
        }
    });
});

// Mark movies
