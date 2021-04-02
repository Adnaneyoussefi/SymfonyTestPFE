$(document).ready(() => {
    $('.capital').click((e) => {
        $('.loading b').show()
        $('.weatherData').hide()
        $.get(e.currentTarget.getAttribute("href"))
        .done((data, textStatus, jqXHR) => {
            $('.weatherData').show()
            $('#weatherImage > img').attr( "src", "http://api.openweathermap.org/img/w/"+data.weather[0].icon+".png" );
            $('#weatherDescription').html(data.weather[0].description)
            $('#weatherTemperature').html(parseInt(data.main.temp - 273.15))
            $('#weatherHumidite').html("<b>Humidity:</b> "+ data.main.humidity+ " %")
            $('#weatherWind').html("<b>Wind:</b> "+ data.wind.speed+" m/s")
        })
        .always(() => {
            $('.loading b').hide()
        })
    })
})