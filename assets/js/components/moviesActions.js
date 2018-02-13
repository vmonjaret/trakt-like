import $ from 'jquery';
import Routing from "./routing";
require('jquery-star-rating-plugin/src/jquery.star.rating');

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
$('#movie-rating').addRating({
    //fieldName: 'movie-rating',
    //fieldId: 'movie-rating-input',
    onClick: (parent, rate) => {
        $.ajax({
            url:Routing.generate('movie_mark'),
            type: "POST",
            dataType: "json",
            data: {
                "movieId": parent.data('movieid'),
                "mark": rate
            }
        });
    },
    iconSize: '48px'
});
