# Projektrapport - Webbteknik II

## Inledning 

Mitt projekt för denna kursen består av en så kallad mash up applikation som kombinerar data from Instagram, Twitter, Google Places samt Foursquare. Användare av applikationen skriver in en plats varav applikationen hämtar data från de olika tjänsterna och presenterar denna data för användaren. Tanken är att man ska kunna få en inblick i vad som försiggår på olika platser runt om i världen genom att få se bilder, läsa tweets samt se vilka platser som är populära.

## Serversida

Jag har valt att jobba med php ramverket "Laravel" på serversidan. "Laravel" är ett MVC-ramverk som även erbjuder abstraktionsmetoder samt ORM:et Eloquent vilket allt bidrar till att man snabbare kan skapa webbapplikationer. Jag har skapat en requestklass som kapslar in CURL-funktionalitet. Denna klass används sedan av alla olika "Webservice"-klasser som finns i min applikation. Varje API jag använder har en "Webservice"-klass samt en "vanlig" klass. "Webbservice"-klassen förbereder anropet och använder sig sedan av min "requestwrapper" för att göra anropet via CURL. Om anropet går bra skapas en instans av av den "vanliga"-klassen som sköter validering.

Varje API har även en separat controller som sköter kontakten med tillhörande "Webbservice"-klass och fångar undantag som kastas om anrop till respektive API inte returnerar HTTP-kod 200. 

Genom att separera anropen till de olika API:erna gentemot att göra alla anrop tillsammans kan jag fortfarande få data från de API:er som fungerar om ett API inte skulle fungera.

Serversidan har även i uppgift att cacha den data som kommer tillbaka från API:erna i en minut. Jag har valt det relativt korta intervallen på en minut eftersom hela idéen med applikationen är att ge en inblick i vad som händer ju NU. Trots den korta cachningstiden får jag betydande fördelar av den. Bland annat genom kortare svarstider för de besökare som söker på en plats som finns cachad. En annan viktigt fördel är att min applikation inte förbrukar lika många anrop till API:erna som i de flesta fall har en gräns på hur många anrop som får göras inom en viss tidsram, utan istället hämtar den cachade datan från min databas. 

Jag cachar även alla statiska resurser på klienten i ett år genom att skicka med Cache-control headers.

Säkerhetsmässigt så "escapear" jag all data som kommer från API:erna för att förhindra eventuella XSS attacker. Jag skyddar även mot CSRF genom att skicka med en "token" vid varje anrop som sedan kollas av mot en "token" som finns sparas i sessionen på servern.

## Klientsida

Klientsidan är byggt som en SPA och fungerar genom att göra tre separata AJAX-anrop till servern för de tre olika API:erna. Om responsen är okej renderas resultatet ut annars renderas ett felmeddelande ut. Om resultatet är bra men tomt, renderas ett meddelande ut som informerar användaren att ingen data kunde hittas för det givna anropet.

Jag har har inte använt mig av någon ramverk eftersom jag bara har en sida som inte är så komplex. Om arkitekturen skulle varit mer komplex med flera olika sidor hade jag använt mig av ramverket "Angular" eftersom jag har tidigare erfarenhet av det samt att det är ett väldigt komplett och gediget ramverk.

För att underlätta "DOM"-maniplulering använder jag mig av "jQuery".

Optimeringar som vidtagits på klientsidan innefattar minifiering samt konkatinering av javaskript och css-filer. Till detta har jag använt mig av Grunt som är en så kallad "taskrunner".

## Risker 

Jag kan inte riktigt hitta några etiska risker med min applikation eftersom den använder sig av data som respektive tjänsts användare har valt att dela med sig av. Det skulle eventuellt kunna vara att användare av de olika tjänsterna som jag använder mig av inte är medvetna om att andra applikationerna komma åt deras data. Det vill säga att de inte är insatta i att det finns ett API eller ens vad ett API är för något. 

Rent säkerhetsmässigt så har jag vidtagit åtgärder som finns beskrivet ovan.

## Reflektion 

Projektet har gått väldigt smidigt utan några egentliga problem. Mitt största hinder under projektet har varit brist på tid. Detta beror på att jag valde att ta en fyra veckor lång semester vilket gjorde att jag inte kunde lägga ner lika mycket tid på projektet som min ambitionsnivå egentligen önskade. Trots minskad arbetstid är jag ändå nöjd med att jag han med alla kraven som ställdes för ett godkänt betyg. Några saker som jag inte fick med som jag hade önskat är bland annat att implementera "Geolocation" så att användaren inte behövt skriva in orten som hen befann sig på.

I sin helhet har detta projektet var mycket lärorikt eftersom jag har fått fördjupade kunskaper av att arbeta med olika webb API:er. Detta är en erfarenheter som kommer att vara mycket relevanta i de flesta kommande projekten jag kommer att göra eftersom det blir mer och mer vanligt att inkludera data från andra tjänster in i sin egen applikation. 

## Betygshöjande egenskaper

Tråkigt nog har jag lagt mig på betygsnivå tre eftersom jag inte har haft så mycket tid. Jag tycker dock själv att min kod är av god kvalitet. 

## Länkar

[Redovisningsfilm](https://dl.dropboxusercontent.com/u/2388401/redovisning-webbteknik-II.mov)
[Länk till projektet](http://webbteknik.eu01.aws.af.cm/)
[Schematisk bild](https://dl.dropboxusercontent.com/u/2388401/chart.pdf)


