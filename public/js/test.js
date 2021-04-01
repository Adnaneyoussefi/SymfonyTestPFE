$(document).ready(() => {
    
    $('.capital').click((e) => {
        $('.loading b').show()
        $('.weatherData').hide()
        $.get(e.currentTarget.getAttribute("href"))
        .done((data, textStatus, jqXHR) => {
            $('.weatherData').show()
            $('#weatherImage > img').attr( "src", "http://api.openweathermap.org/img/w/"+data.weather[0].icon+".png" );
            $('#weatherDescription').html(data.weather[0].description)
            $('#weatherTemperature').html("<b>Temperature:</b> "+ parseInt(data.main.temp - 273.15)+ "°C")
            $('#weatherHumidite').html("<b>Humidity:</b> "+ data.main.humidity+ " %")
            $('#weatherWind').html("<b>Wind:</b> "+ data.wind.speed+" km/h")
        })
        .always(() => {
            $('.loading b').hide()
        })
        
    })
})