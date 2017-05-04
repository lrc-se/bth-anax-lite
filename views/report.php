        <h1>Redovisning</h1>
        <p>Här nedan följer alla redovisningar som hör till kursen <strong>oophp</strong>.</p>
        <h4>Kursmoment</h4>
        <ul>
            <li><a href="#kmom01">Kmom01</a></li>
            <li><a href="#kmom02">Kmom02</a></li>
            <li><a href="#kmom03">Kmom03</a></li>
            <li><a href="#kmom04">Kmom04</a></li>
            <li><a href="#kmom05">Kmom05</a></li>
            <li><a href="#kmom06">Kmom06</a></li>
            <li><a href="#kmom10">Kmom10</a></li>
        </ul>
        <br><hr>
        <section id="kmom01">
            <h2>Kmom01</h2>
            <p>
                I <a href="../../kmom01/guess/index.php">Guess the number</a> använder jag samma bas för sidan i alla varianter, 
                så presentationskoden (HTML + PHP) ser likadan ut hela tiden förutom sökvägar och frånvaro/närvaro av knappar/länkar. 
                Sidan är även sparsamt stilsatt, inklusive undantagshanteraren, men jag har inte lagt någon större tid på det (eller på att integrera spelet i ramverket).
            </p>
            <p>
                Själva koden är rättframt hållen, där jag använder sessionen och <code>Session</code>-klassens <code>getOnce</code>-metod 
                för att hålla reda på och visa all status i de två sista varianterna. För att återställa sessionen har jag även infört en <code>clear</code>-metod i klassen. 
                <code>Guess</code>-klassen innehåller statiska konstanter för minsta värde (1), högsta värde (100) och högsta antal gissningar (6), som både den själv och skripten använder sig av.
            </p>
            <p>
                Ramverksuppgiften fortsätter på det tveksamma spåret att servera en mycket stor mängd färdigskriven kod för studenterna att kopiera in, rätt upp och ner,  
                och sedan kalla för sin. Vad är egentligen meningen med det? "Bygg ett eget ramverk" och "skapat med egna händer" 
                är i sammanhanget kraftiga överdrifter och jag har därför lagt en hel del tid på att verkligen göra saker på egen hand, efter eget huvud, så långt det nu går under förutsättningarna.
            </p>
            <p>
                Till att börja med är min kodstruktur annorlunda än i exemplen (läs: betydligt förenklad) och jag använder mig även delvis av ett annat upplägg när det kommer till kataloger och filer 
                (fast inte på övergripande nivå). Framför allt vyhanteringen är omarbetad för att slippa upprepa så mycket kod hela tiden, 
                där jag har en egen funktion som skapar upp standardvyer utifrån en layoutsida (men man har fortfarande möjlighet att bygga upp enskilda vyer manuellt om man vill).
            </p>
            <p>
                Även huvudmenyn är ordentligt genomarbetad, där jag implementerat stöd för godtyckligt antal undernivåer som hanteras automatiskt genom en rekursiv funktion. 
                Jag hade redan brutit ut konfigurationen till en egen fil innan uppgiftstexten ändrades, så jag kände inte för att backa och göra koden sämre i efterhand. 
                Renderingskoden ligger dock fortfarande i vyn, där jag även har ett par hjälpfunktioner för att hålla reda på aktiva menyval. 
                Observera även att min katalogstruktur för just vyerna som sagt skiljer sig något från uppgiften.
            </p>
            <p>
                Sidans stil är av luftigt, avskalat fullbreddssnitt och använder ett närmast monokromt färgschema med de blå länkarna som enda färgsättning utöver norrskensbilden. 
                Jag har lagt till ett extra menyval för att visa hur menysystemet fungerar, vilket var rätt kul att sätta ihop i både PHP, JS och CSS. 
                Hela webbplatsen är som vanligt responsiv i alla delar, där jag hanterar allt på egen hand, utan CSS-ramverk (ett ramverk åt gången, liksom).
            </p>
            <p>
                Jag har gjort alla extrauppgifter, även om "testsidan" i det här läget alltså mest utgörs av menyraden (som även inkluderar ett 404-exempel). 
                Sökvägen <a href="<?= $app->href('server') ?>"><code>/server</code></a> returnerar PHP-variabeln <code>$_SERVER</code> i JSON-format.
            </p>
            <p>
                SQL-uppgiften är utförd (och testad med MySQL lokalt) till och med punkt 9, men observera att jag valt att använda mig av engelska namn istället för svenska,
                då jag alltid föredrar detta på kodnivå.
            </p>
            <h5>Hur känns det att hoppa rakt in i klasser med PHP? Gick det bra?</h5>
            <p>Inga problem; det är inga direkta nyheter, även om vanan kanske inte är på topp alla gånger.</p>
            <h5>Berätta om dina reflektioner kring ramverk, Anax Lite och din me-sida.</h5>
            <p>
                Utöver ovanstående <em>reflektioner</em> (ähum) vill jag gärna hålla saker och ting så enkla som möjligt och 
                har sett min beskärda del av skräckexempel på när folk krånglat till ett egentligen rätt simpelt upplägg åtskilliga varv för långt, bara för att "man skall göra så" – 
                och av och till har jag även haft det tveksamma nöjet att behöva underhålla sådan kod när den brakat ihop.
            </p>
            <p>
                Jag tenderar därför att välja (eller bygga!) ramverk av den lättare sorten, där man <em>inte</em> slänger in rubb och stubb bara för att man kanske, 
                eventuellt skulle kunna få nytta av en funktion någon gång i framtiden, utan låter reella behov styra – och sedan bygger ut efterhand som nya behov uppenbarar sig. 
                Det är lättare att lägga till än att dra ifrån.
            </p>
            <h5>Gick det bra att komma igång med MySQL? Har du liknande erfarenheter sedan tidigare?</h5>
            <p>
                Jag har använt både MySQL och databaser i allmänhet en hel del förut – och gör det fortfarande på regelbunden basis – så detta var inte heller några problem. 
                För övrigt är det alltid roligt att få chansen att skriva en massa SQL hit och dit...
            </p>
        </section>
        <section id="kmom02">
            <h2>Kmom02</h2>
            <p>
                Sessionsuppgiften implementerar alla funktioner, där <code>session/status</code> visar 6 parametrar. I övrigt använder jag mig av <code>getOnce</code>-metoden 
                från gissaspelet i Kmom01 för att visa meddelanden när man ökar, minskar eller rensar. Extrauppgifterna fanns det inte riktigt tid för denna gång på grund av stundande resor, 
                men de skulle heller inte medföra några svårigheter då de i princip inte innehåller något nytt.
            </p>
            <p>
                Eftersom jag redan byggt upp en fullt fungerande struktur för navigationslisten, inklusive undermenyer, 
                var det en enkel femma att bara lyfta över koden till en ny klass och ändra så konfigurationsfilen returnerar matrisen istället för att spara den i en variabel. 
                Jag har använt <code>ConfigureInterface</code> och <code>ConfigureTrait</code>, men valde sedan att skicka in <code>$app</code> 
                direkt i konstruktorn för att slippa ett steg när jag lägger till objektet i ramverket.
            </p>
            <p>
                Vyn, som ligger i <i>views/incl/navbar2.php</i>, definierar <code>&lt;nav&gt;</code>-stommen och anropar sedan den rekursiva metoden <code>Navbar.renderItems()</code> 
                som skriver ut själva länklistan. Vyn innehåller även knappen som visas när menyn fällts ihop, vilket nu sker vid en något högre brytpunkt eftersom det är fler menyval som skall få plats.
            </p>
            <p>
                För uppgift 3 valde jag månadskalendern, dels för att den verkade roligare/mer utmanande och 
                dels för att tärningsspelet inte heller skulle tillföra så väldigt mycket nytt till de sessionsuppgifter som redan gjorts. 
                Samma tidspress som ovan ledde till att jag inte gjorde båda uppgifterna, men jag lade istället lite mer kraft på kalendern. Se mer nedan.
            </p>
            <h5>Hur känns det att skriva kod utanför och inuti ramverket? Ser du fördelar och nackdelar med de olika sätten?</h5>
            <p>
                Jag ser väl egentligen ingen större skillnad på ren kodnivå, utan det handlar mer om vad det är man vill uppnå med den ena eller andra strukturen. 
                Annars är det väl naturligt att det som är menat att fungera som en del i ramverket faktiskt också <em>är</em> en del i ramverket. 
                Nackdelen är att det blir lite mer boilerplate och "startkod", men det är ändå ganska milt i det här fallet mot för hur det ibland kan vara.
            </p>
            <h5>Hur väljer du att organisera dina vyer?</h5>
            <p>
                Som jag nämnde <a href="#kmom01">ovan</a> använder jag en egen funktion för att skapa en grundlayout, som sedan går igen på de flesta (för att inte säga alla) sidor. 
                Funktionen kan ta emot argument på flera olika sätt, så det finns fortfarande goda möjligheter att styra hur sidan byggs upp inom de uppsatta ramarna, 
                såsom t.ex. med kalendern. Fler inställnings&shy;möjligheter kan också med enkla medel läggas till senare om jag ser att det finns ett behov av det.
            </p>
            <h5>Berätta om hur du löste integreringen av klassen <code>Session</code>.</h5>
            <p>
                Det var inga konstigheter med det, utan det var bara att lägga in koden på därför avsedd plats och sedan instantiera klassen i <code>$app</code> på <em>därför</em> avsedd plats. 
                Min version av klassen skiljer sig en del från den i exemplet, men funktionen är i stort sett densamma, förutom att jag alltså även infört <code>getOnce()</code>.
            </p>
            <h5>Berätta om hur du löste uppgiften med månadskalendern: hur du tänkte, planerade och utförde uppgiften samt hur du organiserade din kod.</h5>
            <p>
                Först tänkte jag igenom hur jag enklast skulle kunna både lagra de data jag behövde och sedan använda dem för att skapa en passande vy. 
                Den lösning jag landade i var att skapa en (1) månadsklass som initieras med år och månadsnummer och sedan kan användas för att utläsa de värden jag behöver för att rita upp kalendern. 
                Häri ingår två statiska listor (månadsnamn och veckodagsnamn), längd (med hjälp av <code>cal_days_in_month()</code>) 
                samt metoder för att ta reda på datumet för månadens första dag liksom att identifiera innevarande dag. Konstruktorn kastar också ett undantag om man skickar in ogiltiga startvärden. 
                Däremot innehåller klassen inga renderingsmetoder, då jag helst vill hålla så mycket som möjligt av HTML-koden i vyerna.
            </p>
            <p>
                Kalendervyn är av klassiskt snitt, med en rubrik och två blädderknappar överst, en bild i mitten och en dagstabell underst, med veckonummer längst till vänster. 
                Bilderna är mina egna och kommer från en fysisk kalender jag nyligen producerade. Föregående och nästkommande månad instantieras som egna <code>Month</code>-objekt 
                genom en enkel kodsnutt som håller koll på årsväxlingar. Visningen är helt och hållet responsiv, delvis med hjälp av ett par trick som förkortar tabellrubrikerna när utrymmet krymper.
            </p>
            <p>
                Tabellen ritas upp genom två nästlade loopar som utgår från månadens startdatum, där dagarna som ligger utanför månaden (men inom tabellen) 
                enkelt kan identifieras genom att jämföra den stegande positionen med dess första respektive sista dag. 
                Dessa "utomstående" dagar liksom söndagar (som identifieras med modulus) och innevarande dag markeras med olika CSS-klasser vilka sedan stilsätts, 
                men däremot ingår inga övriga helgdagar eller bemärkelsedagar (för tillfället, åtminstone). För att få ut rätt värden nyttjar jag på flera ställen <code>DateTime::format()</code>, 
                som har många användbara format&shy;parametrar.
            </p>
            <p>
                I routeskriptet definierar jag två sökvägar som leder till kalendern: en "naken" (<code>calendar</code>) och en med parametrar (<code>calendar/{year}/{monthNum}</code>). 
                Den förstnämnda skapar ett <code>Month</code>-objekt utifrån aktuell tidpunkt, medan den sistnämnda försöker skapa ett utifrån routeparametrarna, 
                men om den misslyckas fångar den undantaget och omdirigerar till aktuell månad istället. I samtliga fall skickas det färdiga objektet med till vyn, 
                så det är routefunktionernas uppgift att skapa det.
            </p>
            <p>
                Slutligen har jag även förberett en "mindre variant av kalendern som passar i en sidopanel", vilket jag löste genom att bryta ut själva kalendern till en egen vy 
                (<i>views/incl/calendar.php</i>) vilken i sin tur kan inkluderas av olika föräldravyer (för närvarande <i>views/calendar.php</i> och <i>views/calendar-small.php</i>) 
                som sätter den booleanska vyvariabeln <code>$small</code>. Detta värde styr sedan vissa delar av presentationen, såsom bildens storlek (med hjälp av CImage) och tabellrubrikerna, 
                så att kalendern kan göras ännu lite mindre på ett bra sätt. När jag ändå höll på införde jag även en liknande variabel <code>$noImage</code>, 
                som förhindrar att bilden skrivs ut om den är satt till <code>true</code>.
            </p>
            <p>
                Dessa två funktioner kan testas i båda de publicerade kalendersökvägarna genom <code>GET</code>-parametrarna <code>small</code> och <code>noimage</code>, 
                som kan sättas till lämpligt värde som PHP tolkar som sant, men tänk på att den minimerade versionen är menad att användas i ett litet utrymme, 
                så den ser inte jättebra ut i fullskärmsläge. Parametrarna följer heller inte med när man bläddrar framåt och bakåt, så detta skall bara ses som en enkel funktions&shy;demonstration.
            </p>
            <h5>Några tankar kring SQL så här långt?</h5>
            <p>Fortfarande roligt, så jag gjorde klart hela SQL-uppgiften av bara farten. Även denna gång är all kod testkörd med MySQL lokalt samt använder fortsatt engelska namn. </p>
        </section>
        <section id="kmom03">
            <h2>Kmom03</h2>
            <p>
                Ännu ett stort moment, som kändes ännu större eftersom jag hade mindre tid till mitt förfogande på grund av en skidresa (som dock var väl värd tiden).
            </p>
            <p>
                Jag började med att bestämma databasschemat och planerade redan från start för att integrera uppgift 1 och 2 med varandra. 
                Min användartabell innehåller därför attributet <code>level</code> som fungerar som behörighets&shy;flagga för administrations&shy;delen och av samma anledning har jag ingen 
                <i>sql/setup-admin.sql</i>, utan allt som behövs för bägge uppgifterna finns i <i>sql/setup-user.sql</i>. Skriptet definierar fyra användare från start, 
                varav en supera&shy;ministratör (se nedan), en administratör och två vanliga användare.
            </p>
            <p>
                Användarna registreras med ett fåtal uppgifter och blir kanske inte jätte&shy;intressanta i den här tappningen, 
                men det är enkelt att utöka det hela om man vill då grunden nu är lagd och resten bara är anpassningar. Som föreslagit har jag begränsat lagringen av profilbilder till URL:er, 
                men detta gör det också enkelt att implementera en upp&shy;laddnings&shy;funktion senare då dataformatet med fördel kan behållas även i det fallet.
            </p>
            <p>
                Jag bestämde mig också tidigt för att lägga in inloggningen i navigations&shy;listen, vilket jag löste genom några <code>if</code>-satser i min <i>config/navbar.php</i> 
                som bygger upp olika meny&shy;strukturer beroende på om man är inloggad eller inte, samt om man är administratör eller inte. 
                Är man inte inloggad kan man gå till registrerings&shy;sidan eller inloggnings&shy;sidan, 
                medan om man är inloggad visas användarnamnet intill en miniatyr av profilbilden och undermenyn ger tillgång till användarprofilen samt eventuellt adminpanelen. 
                Detta upplägg gjorde det enkelt att få plats med alla menyval på ett smidigt sätt, inklusive markering av aktuell avdelning/<wbr>sida.
            </p>
            <p>
                Jag har organiserat alla mina användar&shy;relaterade routefunktioner i <i>config/routes/user.php</i>, där sökvägarna följer en genomtänkt struktur, 
                och vyerna ligger i <i>views/user</i>. Efter att inloggning skett sparas användarens ID (primärnyckel) 
                i sessionen och alla sökvägar med behörighetskrav kontrollerar motsvarande användares nivå i alla steg, 
                så att man t.ex. inte kan skaffa sig otillbörlig åtkomst genom att skicka egenskapade <code>POST</code>-anrop. Se vidare under frågorna nedan för mer om kodens upplägg.
            </p>
            <p>
                I kakan valde jag att lagra tidpunkt för när den senaste inloggningen skedde (d.v.s. inte det senaste <em>besöket</em>). 
                Detta är väl kanske något som borde sparas direkt i databasen om det verkligen är intressant och skall användas till något, 
                så det är med här mest bara för att demonstrera hur det fungerar.
            </p>
            <p>
                I adminpanelen listas alla användare tillsammans med fyra typer av UI-kontroller: en sökruta som matchar fälten användarnamn, födelsedatum och e-post 
                (fritext, icke skift&shy;läges&shy;känsligt), en inställning för hur många poster som skall visas per sida, sortering på kolumnrubriker samt slutligen framåt- 
                och bakåtknappar för att bläddra mellan sidorna om det finns flera. Detta hanteras med <code>GET</code>-parametrar och en hjälpmetod i <code>App</code> 
                som byter ut värden i söksträngen (smart sak det). Själva filtreringen sker i routefunktionen med hjälp av användar&shy;funktions&shy;klassen (se nedan), 
                men här saknade jag verkligen LINQ från .NET som annars underlättar sådana saker väldigt mycket.
            </p>
            <p>
                Behörighets&shy;nivåerna är upplagda så att man endast har rättigheter att ändra användarposter med samma eller lägre nivå än man själv har, 
                så det är bara super&shy;administratörer (nivå 2) som kan lägga till och redigera andra super&shy;administratörer. Man kan dock aldrig ändra sin egen nivå, eller ta bort sitt eget konto. 
                Från adminpanelen kan man också skapa en ny användare, där man med motsvarande begränsningar kan välja nivå för denna.
            </p>
            <p>
                Kravet om borttagning är lite tveksamt då man sällan i en verklig tillämpning faktiskt <em>raderar</em> poster, eftersom det ofta leder till problem med referens&shy;integritet, 
                men i och med att dessa användare inte är knutna till något speciellt här har jag ändå implementerat äkta <code>DELETE FROM</code>-funktionalitet – 
                fast med ett bekräftelse&shy;steg för att vara på den säkra sidan. Det finns dock även ett attribut <code>active</code> som används för att spärra ett konto, 
                vilket ofta uppnår samma effekt. Använd <i>admin</i>/<wbr><i>correcthorsebatterystaple</i> för att testa administratörs&shy;kontot.
            </p>
            <p>
                Utöver momentets uppgifter har jag också byggt om delar av koden för att underlätta för mig själv, lagt till några fler hjälpmetoder i <code>App</code> 
                samt infört riktiga docblock-kommentarer. Några smärre uppdateringar i stilsättningen har det också blivit, 
                där jag bl.a. gått över till flexbox&shy;layout i vissa delar samt gjort vad jag kunnat för att alla nya (och gamla) vyer skall fungera så bra som möjligt responsivt, 
                även om just användar&shy;tabellen i adminpanelen (se nedan) som vanligt blir en kompromiss.
            <p>
                SQL-uppgiften slutförde jag som sagt redan i Kmom02.
            </p>
            <h5>Hur kändes det att jobba med PDO, SQL och MySQL?</h5>
            <p>
                Alla ingående delar är välbekanta för mig, var för sig och i kombination, så det var inga konstigheter nu heller.
            </p>
            <h5>Reflektera kring koden du skrev för att lösa uppgifterna – klasser, formulär, integration med Anax Lite?</h5>
            <p>
                Jag gjorde en egen databasklass kallad <code>DbConnection</code> som nu är integrerad i ramverket och återanvänder samma anslutning under hela anropets livstid. 
                Klassen innehåller generiska metoder för att utföra selektion och uppdatering, där jag nyttjar optionella argument för att hantera eventuella parametrar till SQL-satserna. 
                Poster hämtas som anonyma objekt som standard, men man kan även skicka med ett klassnamn för att instantiera en specifik klass, vilket jag utnyttjar för användar&shy;objekten. 
                Upp&shy;kopplings&shy;uppgifterna finns i en fil <i>config/db.php</i> som inte ingår i repot, men det finns en <i>config/db-example.php</i> 
                som illustrerar hur den är upplagd och automatiskt anpassar sig till lokal respektive publicerad miljö. 
                Jag gjorde även ett ingrepp i undantags&shy;hanteraren för att förhindra att den läcker dessa uppgifter om PDO kraschar.
            </p>
            <p>
                För användar&shy;systemet har jag dels en modellklass <code>User</code> som motsvarar databas&shy;tabellen plus några hjälpmetoder och konstanter, 
                och dels en <code>Functions</code>-klass (i samma namnrymd) som innehåller metoder för att hantera tillhörande databas&shy;operationer, datavalidering och objekt&shy;instantiering. 
                Detta gjorde det enkelt att skriva route&shy;funktionerna, då dessa kunde hållas på en hög nivå utan att veta något om hur databasen är uppbyggd 
                (men det finns fortfarande möjlighet att prata direkt med databasen via <code>App::db</code> om man ändå skulle vilja det). 
                Uppgifter om den inloggade användaren hämtas från databasen utifrån det ID som sparats i sessionen.
            </p>
            <p>
                Jag använder samma formulär (vy) för att skapa och redigera användare, för både gäster, vanliga användare och administratörer, 
                där respektive routefunktion sätter olika variabler för att styra vad som visas och vart uppgifterna skickas. Indatan valideras sedan med hjälp av funktionsklassen ovan, 
                där jag fick stänga av några PHPMD-varningar som kort och gott inte är relevanta i sammanhanget – 
                jag vill ha all validering på samma ställe för att det skall bli mer lätthanterligt och det blir rätt många olika fall som skall täckas in för att ge användaren informativa felmeddelanden. 
                Dessa meddelanden skrivs ut i en lista i vyn, där det instantierade <code>User</code>-objektet används för att fylla i formuläret med existerande data. 
                <code>Session::getOnce()</code> används för att skicka meddelanden mellan vyerna, för både fel och bekräftelser.
            </p>
            <p>
                Slutligen lade jag även till en <code>Cookie</code>-klass av samma stuk som <code>Session</code> i ramverket (<code>App::cookie</code>), då jag aldrig gjorde det i förra momentet. 
                Användarklassen är helt fristående, medan funktionsklassen tar emot en <code>DbConnection</code>-instans i konstruktorn, 
                men ingen av dem ingår som integrerad komponent i ramverket som de andra modulerna utom kalendern gör.
            </p>
            <h5>Känner du dig hemma i ramverket, dess komponenter och struktur?</h5>
            <p>
                Jodå, även om jag av och till finner vissa delar lite begränsande och det kliar i fingrarna att gå in och justera/<wbr>korrigera i koden här och var...
            </p>
            <h5>Hur bedömer du svårighetsgraden på kursens inledande kursmoment? Känner du att du lär dig något/bra saker?</h5>
            <p>
                Framför allt har det varit <em>stora</em> moment, särskilt 1:an och 3:an, så det är där det mesta av "svårigheten" ligger – själva teknikerna är inte så särdeles komplicerade i sig. 
                Egentligen är det inte så mycket nytt heller, då mycket av detta i grund och botten känns som upprepning från <a href="https://dbwebb.se/htmlphp"><b>htmlphp</b></a> (och då särskilt BMO), 
                bara med lite annan inramning. Den största behållningen är nog en ökad vana av OO-PHP samt att jobba inom ett ramverk; 
                även om just Anax Lite inte nödvändigtvis är att betrakta som "allmänt gångbart" ute i det vilda går grund&shy;komponenterna och arkitekturen igen, 
                så den ökade vanan kommer in även där.
            </p>
        </section>
        <section id="kmom04">
            <h2>Kmom04</h2>
            <p>
                Trenden med väldigt omfattande moment fortsätter. Skulle ni inte hålla koll och justera efterhand? 
                Vill man göra mer än bara det absolut mest grundläggande, såsom validering av indata, feltolerans, stilsättning, responsivitet o.s.v., ökar arbets&shy;belastningen fort. 
                Får man be om lite återhållsamhet framledes, månne?
            </p>
            <p>
                Jag har valt att knyta innehåll till användare (se mer nedan) och det blev därmed naturligt att göra hanteringen av detta som en del i det existerande användar&shy;systemet. 
                När man är inloggad får man nu även menyvalet <em>Mitt innehåll</em> under sitt användarnamn, varifrån man kan lägga till, redigera och ta bort sitt eget innehåll. 
                Är man administratör har man även tillgång till valet <em>Hantera innehåll</em> som fungerar i princip likadant men visar samtliga användares innehålls&shy;poster. 
                Även här har jag utnyttjat behörighets&shy;nivåerna så att en administratör endast kan påverka innehåll skapat av någon på samma eller lägre nivå. 
                Super&shy;administratörer kan även ändra en innehålls&shy;posts skapare.
            </p>
            <p>
                Båda dessa vyer bygger på användar&shy;administrations&shy;vyn från föregående moment, med en motsvarande tabell och bakomliggande kod som sköter sortering och databaskoppling 
                (se mer nedan). Jag bröt även ut pagineringen till en egen vy så att jag inte behövde upprepa hela det kodstycket. 
                Precis som tidigare klarar visningen av felaktiga parametrar utan att bryta ihop, där standardvärdet för antal poster per sida nu är satt till 10. 
                Tabellen i adminläget är ordentligt full, men fungerar ändå hjälpligt responsivt bara man är beredd att skrolla/<wbr>svepa lite. 
                Borttagna poster markeras med rött och opublicerade med gult.
            </p>
            <p>
                Nyskapande och redigering använder samma formulär som anpassar sig efter situationen. 
                Valen för publiceringstid ändras beroende på vilka inställningar som tidigare gjorts och om man väljer att specificera en egen tid kontrolleras att tidpunkten inte blir retroaktiv. 
                Eftersom vem som helst kan lägga till innehåll (registreringen av användarkonton är som bekant öppen) har jag valt att begränsa valen av formaterare till en förvald lista, 
                där eventuell HTML-kod alltid rensas bort i första steget vid utskrift som en säkerhetsåtgärd. Markdown är förvalt, då det ger mest frihet, 
                och alla övriga val inkluderar <code>nl2br</code>.
            </p>
            <p>
                Bloggindexet använder sig också av den nya paginerings&shy;vyn och inkluderar i sin tur vyn för ett enskilt blogginlägg, 
                där några medskickade variabler styr hur det presenteras. Jag har lagt till möjlighet att skapa utdrag, vilket jag löste på ett enkelt (och något begränsat) 
                sätt genom att matcha slutet på den första <code>&lt;p&gt;</code>-taggen. Denna inställning och antal poster per sida hämtas från <i>config/blog.php</i>. 
                Varje enskilt blogginlägg visar länkar till föregående och nästa inlägg, om det finns sådana.
            </p>
            <p>
                Alla kan ta bort sina egna poster och för en vanlig användare är de sedan borta, medan en administratör kan se dem och återställa dem. 
                Om en gäst eller användare klickar på en länk som leder till ett renderat innehåll som är markerat som borttaget eller opublicerat blir det <code>404</code>, 
                medan en administratör ser innehållet tillsammans med ett meddelande om dess synlighets&shy;status och en länk för att återställa eller redigera det. 
                Borttaget innehåll kan inte redigeras innan det återställts.
            </p>
            <p>
                Flash&shy;meddelanden hade jag redan implementerat, men jag har gjort om upplägget något under huven så att hanteringen av dem blir enklare i vyerna. 
                Jag har även stuvat om lite i navigationen så att allt skall få plats på ett bra sätt samt uppdaterat stilsättningen lite grann. Backupen av databasen i uppgift 3 är gjord från 
                <i>blu-ray</i> med phpMyAdmin på eftermiddagen 2017-04-23 i samband med inlämningen och det verkliga innehållet kan mycket väl ha ändrats sedan dess.
            </p>
            <p>
                Observera att eftersom jag i det förra momentet införde en lägsta lösenords&shy;längd om 8 tecken fungerar inte de efterfrågade standard&shy;användarna. 
                Använd istället <i>admin</i>/<wbr><i>correcthorsebatterystaple</i> respektive <i>doe</i>/<wbr><i>doedoedoe</i> för att logga in.
            </p>
            <h5>Finns något att säga kring din klass för texfilter, eller rent allmänt om formatering och filtrering av text som sparas i databasen av användaren?</h5>
            <p>
                För det första skrev jag den själv och kallade den för <code>Formatter</code> istället, då jag tyckte det passade bättre. 
                Klassens metoder bygger på exemplen, men i egna versioner, och inkluderar även <code>strip</code>, <code>esc</code> och <code>slug</code>. 
                Metoden <code>apply()</code> kan hantera både en kommaseparerad sträng och en matris som argument, 
                klarar av extra mellanslag och använder sig av en lista över tillgängliga formaterare för att anropa motsvarande metoder automatiskt 
                (okända formaterare skippas bara, utan att kasta undantag). Klassen är integrerad som <code>App::format</code>, men har inga egna beroenden.
            </p>
            <p>
                I största allmänhet är jag av åsikten att det i de allra flesta fall är bäst att lagra innehåll precis som det tas emot i databasen och att utföra all formatering och sanering vid utskrift. 
                På detta sätt förvanskas ingen information längs vägen och man får större möjligheter att använda datan på flera olika sätt utan att behöva "backa" mellan olika format. 
                I gengäld ställer detta högre krav på disciplin vid utskrifter, så man får vara lite på tå. Lagrar man ren HTML, som i ett riktigt CMS, 
                är "rådataspåret" också den enda rimliga vägen att följa.
            </p>
            <h5>Berätta hur du tänkte när du strukturerade klasserna och databasen för webbsidor och blogginlägg.</h5>
            <p>
                Jag har aldrig tyckt speciellt mycket om användandet av <i>slugs</i> i URL:er, särskilt inte när de automat&shy;genereras utifrån riktigt långa rubriker, 
                så jag bestämde mig för att dra formuleringen "fungera <em>(ungefär)</em> som i artikeln" till sin spets och helt sonika skippa dem helt och hållet här. 
                Istället använder jag mig av begreppet "etikett", som utgör den sista delen av sökvägen (motsvarar ungefär artikelns "path"), för sidor och block, 
                medan blogginlägg endast identifieras genom sitt ID. Jag tycker det blir enklare och renare så – och dessutom får jag kortare URL:er.
            </p>
            <p>
                I övrigt ingår <code>userId</code> som främmande nyckel i innehålls&shy;tabellen och pekar ut innehållets skapare. 
                Eftersom det går att radera användare på riktigt har denna även inställningen <code>ON DELETE SET NULL</code> 
                så att referens&shy;integriteten upprätthålls i de fall det finns innehåll knutet till en användare som tas bort (för dessa poster visas skaparens namn som "(okänd)" i vyerna). 
                Datumfälten har datatypen <code>DATETIME</code> snarare än <code>TIMESTAMP</code> för att det skall bli lättare att tolka dem när man kommunicerar direkt med databasen och saknar 
                <code>DEFAULT</code>-värden (delvis på grund av det kända MySQL-versions&shy;problemet). Borttagning hanteras genom attributet <code>deleted</code> snarare än genom <code>DELETE FROM</code>.
            </p>
            <p>
                Jag har bara en (1) modellklass <code>Content</code>, där <code>type</code>-egenskapen berättar vilken typ av innehåll en objektinstans representerar. 
                Denna klass är precis som i fallet med användare i <a href="#kmom03">Kmom03</a> en ren dataklass utan externa beroenden, 
                med några väl valda hjälpmetoder för att underlätta vanliga frågeställningar. 
                All annan funktionalitet ligger på samma sätt som sist i en separat funktionsklass som sköter all databaskoppling och datavalidering. 
                Där finns även en metod <code>getUser()</code> som hämtar innehållets skapare, då modellklassen endast innehåller den främmande nyckeln som sådan.
            </p>
            <p>
                Resten av koden som hanterar innehållet återfinns i routefunktionerna, som utför minst lika rigorösa kontroller i alla steg som i förra momentet, 
                liksom gör sitt bästa för att ge användaren informativa meddelanden oavsett situation och utfall.
            </p>
            <h5>Förklara vilka sökvägar som används för att demonstrera funktionaliteten för webbsidor och blogg (så att en utomstående kan testa).</h5>
            <p>
                Bådadera nås via valet <em>Innehåll</em> i navigationslisten, som har underval som heter just <em>Sidor</em> och <em>Inlägg</em>. 
                Det förstnämnda öppnar en undermeny där samtliga synliga sidor listas i publicerings&shy;ordning,
                medan det andra leder till bloggens startsida som i sin tur listar alla synliga inlägg i omvänd publicerings&shy;ordning. 
                Rent allmänt nås dessa båda typer av innehåll genom sökvägarna <code>content/<wbr>page/<wbr>{etikett}</code> respektive <code>content/<wbr>blog/<wbr>{id}</code>.
            </p>
            <p>
                Innehållstypen block demonstreras på sidan <a href="<?= $app->href('test/test7') ?>">Test 7</a> och textformateraren på sidan <a href="<?= $app->href('test/test1') ?>">Test 1</a>, 
                som båda återfinns under <em>Test</em> i navigationen. På den sistnämnda sidan visas rå källtext följd av motsvarande renderade utskrift för ett antal olika formatval.
            </p>
            <h5>Hur känns det att dokumentera databasen så här i efterhand?</h5>
            <p>
                Inte heller detta är några konstigheter, även om jag vanligtvis föredrar att göra tvärtom, 
                d.v.s. först skapa en databasmodell och sedan låta lämpligt verktyg generera motsvarande SQL-kod utifrån denna istället.
            </p>
            <h5>Om du är självkritisk till koden du skriver i Anax Lite, ser du förbättrings&shy;potential och möjligheter till alternativ struktur av din kod?</h5>
            <p>
                Det är/gör jag alltid. En sak jag diskuterat en hel del med mig själv om är upplägget med modellklass/<wbr>funktionsklass, som nu förekommer i två varianter. 
                Å ena sidan gör det att modellen kan hållas ren och oberoende och övrig kod som behöver nyttja databasfunktioner kan använda sig av högnivåanrop istället för att kommunicera med databasen direkt, 
                vilket gör routefunktionerna och vyerna enklare och koden mer återanvändbar i stort.
            </p>
            <p>
                Å andra sidan blir det en rätt hög specialisering och funktionsklassens komplexitet ökar i motsvarande grad, 
                där det även blir en hel del överlappning mellan klasser som är knutna till olika modeller, då mycket av databaskoden är likadan eller likartad. 
                Även routefunktionerna har mycket gemensamt, vilket blev särskilt tydligt nu när jag bara kopierade över routefilen från användar&shy;systemet 
                och sedan bytte ut eller utökade vissa delar för att passa in i det nya sammanhanget – jag behöver inte skriva all kod från grunden, men stora delar blir mest bara upprepning.
            </p>
            <p>
                I korthet blir det i princip en egen, fristående mini-ORM per modell, vilket i ett större sammanhang skulle vara jobbigt att underhålla, 
                men samtidigt är det svårt att få till en universell, heltäckande ORM som passar alla uppgifter som jag skulle vilja använda den till – 
                det är därför man vanligtvis använder färdiga ramverk för sådant (och jag saknar fortfarande LINQ). Vi får se om jag nöjer mig med ren SQL i kommande uppgifter istället.
            </p>
            <p>
                I övrigt klagar PHPMD på just komplexitet och beroenden här och var, 
                men jag har valt att bara notera och sedan tysta flera av dessa varningar på väl valda ställen eftersom det enligt min bedömning skulle bli <em>mer</em> 
                otydligt och svårhanterbart att bryta upp saker och ting ytterligare i förekommande fall. Att t.ex. <code>App</code> har många beroenden är fullt naturligt då denna klass är 
                <em>avsedd</em> att omsluta ramverkets alla resurser. Och så vidare. 
                Rent allmänt är det ett problem att automatiska analysverktyg inte är medvetna om alla omständigheter och många av de strikta gränsvärdena känns helt godtyckliga, 
                så lite svängrum måste man få ha.
            </p>
        </section>
        <section id="kmom05">
            <h2>Kmom05</h2>
            <p>
                Jag började med att skriva och testa all databaskod direkt mot min lokala MySQL-server och först när detta började fungera som jag ville övergick jag till att skapa gränssnittet i Anax Lite. 
                Min databas är mindre än den i exemplet, men har i gengäld fler och striktare inställningar för att upprätthålla normalisering, integritet och konsistens. 
                Min tabell för orderrader innehåller även attributet <code>unitPrice</code> för att man skall kunna ändra produkters priser över tid utan att påverka tidigare lagda beställningar.
            </p>
            <p>
                De på förhand inlagda produkterna har telemarkstema och det finns ett par existerande beställningar, där en är markerad som levererad. 
                Produkter kan markeras som otillgängliga (ej till salu) istället för att tas bort, 
                medan en beställning kan raderas helt och hållet utifrån antagandet att detta endast behöver göras om den avbryts innan leverans, 
                eftersom den i annat fall så att säga redan är lagd till handlingarna. Om en beställning tas bort raderas även dess tillhörande orderrader genom en <code>ON DELETE CASCADE</code>-regel 
                för den främmande nyckeln. Produkterna har tillfälliga bilder som i avsaknad av frontend syns bäst i mobilläge i redigerings&shy;formuläret (se nedan).
            </p>
            <p>
                Jag har också gjort några databasvyer för att enklare visa orderstatus utan att behöva skriva alla <code>JOIN</code>-satser 
                varje gång och det finns också några lagrade procedurer för att uppdatera lagersaldo och lägga till produkter till en beställning, 
                där den sistnämnda minskar lagersaldot i motsvarande grad i en transaktion. Allt detta finns dokumenterat i <i>sql/setup-webshop.md</i>.
            </p>
            <p>
                Uppgiften med varukorgen har jag valt att basera på just lagrade procedurer i stor utsträckning, så det finns ett antal sådana som man kan anropa med väl valda parametrar 
                (där vissa är frivilliga) för att hantera flödet. Varukorgen är en egen tabell som i sin tur är knuten till produkterna via en kopplingstabell. 
                Korgen kan knytas till en kund direkt vid skapandet eller också existera fritt fram till det är dags att göra en beställning av den, 
                vilket också sker med en lagrad procedur. Denna använder sig av en <i>cursor</i> för att stega igenom korgens innehåll och lägga till orderrader, 
                vilket jag gjorde för att kunna säkerställa att varje enskild produkt verkligen går att beställa (är markerad som "till salu" respektive finns i tillräcklig mängd). 
                Om hela operationen går igenom tas varukorgen bort, tillsammans med tillhörande rader i kopplings&shy;tabellen, eftersom den då spelat ut sin roll.
            </p>
            <p>
                Kontrollen av huruvida det går att beställa ett visst antal av en viss produkt har jag lyft ut till en egendefinierad funktion och genererandet av lagersaldo&shy;varningar 
                ligger i en <code>AFTER UPDATE</code>-trigger. Triggern löses endast ut när saldovärdet passerar 5 uppifrån, 
                d.v.s. det läggs inte till rader i varnings&shy;tabellen om saldot t.ex. ändras från 4 till 1. 
                Det finns även en färdig vy man kan köra <code>SELECT</code> mot för att visa vilka produkter som behöver beställas från leverantör, 
                där jag antagit att det vid en praktisk implementation skall till någon form av markering av när så skett (vilket hanteras med attributet <code>handled</code>). 
                Observera att triggern genererar varningar på <i>blu-ray</i> på grund av 
                <a href="http://stackoverflow.com/questions/36137746/warning-unsafe-statement-written-to-the-binary-log-using-statement" target="_blank">replikerings&shy;inställningar</a> 
                som jag inte rår över, men den fungerar annars som den skall (och även på min lokala server).
            </p>
            <p>
                Flera av procedurerna använder transaktioner för att säkerställa att de arbetar med och släpper ifrån sig aktuella värden, 
                men för att detta skulle fungera som avsett behövde jag även definiera en s.k. <code>EXIT HANDLER</code> som rullar tillbaka transaktionen om ett undantag kastas längs vägen, 
                eftersom MySQL annars bara fortsätter med nästa operation i transaktionen med inkonsistens som följd. Jag har även flera egna kontroller här och var som kör <code>ROLLBACK</code> 
                om de inte är nöjda med de värden de får tillbaka – allt för att se till så att systemet fungerar enligt specifikation.
            </p>
            <p>
                Administrations&shy;gränssnittet kommer man åt genom sin användarmeny när man är inloggad som administratör (<i>admin</i>/<wbr><i>correcthorsebatterystaple</i>), 
                på samma sätt som de andra kontroll&shy;panelerna. Detta gränssnitt, som ser ut och fungerar som de övriga, 
                är enkelt hållet och tillåter endast redigering av produkter samt ändring av lagersaldo – kategorierna är, åtminstone för tillfället, fördefinierade utan redigerings&shy;möjlighet. 
                Precis som i användar&shy;administrationen kan man utföra fritext&shy;sökning för att filtrera listan, vilket här matchar i produktnamn, beskrivning och kategorinamn. 
                Produkter som ej är till salu markeras med rött och sådana med lagersaldo som understiger 5 med gult. Observera att en förändring av lagersaldo (genom funktionen "Lagerför") 
                utlöser varnings&shy;triggern ovan om förändringen passerar 5 uppifrån. Man kan få alla aktiva varningar som JSON genom en länkknapp i gränssnittet, 
                vilket tillsammans med föregående funktion kan användas för att testa triggern.
            </p>
            <h5>Gick det bra att komma igång med det vi kallar programmering av databas, med transaktioner, lagrade procedurer, triggers och funktioner?</h5>
            <p>
                Japp, för jag har sysslat med samtliga förut, på flera olika plattformar. Det är dock alltid lite klurigt och tarvar ofta en del test innan allt går precis som tänkt, 
                åtminstone när det gäller lite mer komplexa skeenden och automati&shy;seringar.
            </p>
            <h5>Hur är din syn på att programmera på detta viset i databasen?</h5>
            <p>
                För det första är det kul, men alltså också utmanande. Det öppnar upp fler möjligheter och kan förenkla vanliga operationer och frågor, 
                liksom säkerställa att affärsregler efterlevs samt automatisera saker som loggning och varningar, 
                men har även potential att göra saker svårare och totalt sett sämre i slutändan, särskilt ur ett underhålls&shy;perspektiv. 
                Huruvida man bör förlägga kod till databasen eller applikationen, eller i vilken fördelning, har därför samma svar som vanligt: det beror på.
            </p>
            <p>
                En fördel med att utföra t.ex. filtrering direkt i databasen är att den kan återanvändas av olika frontend&shy;applikationer, 
                liksom att man endast behöver skicka den filtrerade tabellen tillbaka från servern vilket kan ha betydelse om det rör sig om stora datamängder och/eller hög trafiktäthet. 
                En lagrad procedur är också effektiv då den kan förkompileras och hela hanteringen ligger i databas&shy;hanteraren, från start till slut.
            </p>
            <p>
                Beroende på hur specifika operationerna är kan detta dock innebära att man så att säga flyttar in affärslogik i databasen istället för att låta detta vara en del av den styrande applikationen, 
                vilket bl.a. kan leda till underhålls&shy;svårigheter längre fram då man får kod på fler ställen. Ur arkitektur&shy;synpunkt kan man även vilja hålla datalagret "rent", 
                d.v.s. utan någon egen kontrollerande funktion, i och med att implementationen annars med nödvändighet blir plattforms&shy;specifik. 
                Att anropa den lagrade proceduren kräver också någon form av direktkoppling till databasen med tillhörande hantering av resultatet, 
                vilket kan innebära en lägre abstraktions&shy;nivå än önskat om man annars skulle kunna använda sig av ett ORM-ramverk av något slag för att sköta åtkomsten.
            </p>
            <p>
                Huruvida man skall utnyttja en lagrad procedur eller inte för transaktioner inom en och samma databas ger också upphov till likartade frågeställningar, 
                men det skall nämnas att om man kontrollerar transaktionen på applikationsnivå får man större flexibilitet och har t.ex. 
                möjlighet att låta även andra saker än databas&shy;operationerna i sig styras av hur de ingående delarna fortlöper eller misslyckas.
            </p>
            <p>
                Vad gäller att utnyttja databas&shy;programmering inom ramarna för Anax Lite – nu, framledes eller retroaktivt – ser jag möjligheter för det, ja, 
                t.ex. för filtrerings&shy;- och sorterings&shy;funktionerna som återkommer på flera ställen. Det skulle innebära mindre SQL-kod i PHP-komponenterna, 
                som då blir "renare" och mer överskådliga, men också göra databas&shy;kommunikationen mindre konsekvent då vissa delar skulle ligga på en annan nivå än resten. 
                Jag har valt att inte gå den vägen nu, utan mina procedurer o.dyl. är i stort sett begränsade till varukorgs- och order&shy;uppgiften 
                (lagersaldo&shy;funktionen i gränssnittet utnyttjar dock proceduren <code>addStock</code>).
            </p>
            <h5>Några reflektioner kring din kod för backenden till webbshoppen?</h5>
            <p>
                Koden bygger på och fungerar som de tidigare gränssnitten för användare och innehåll så det var en rätt enkel sak att kopiera, modifiera och anpassa både vyer, 
                routefunktioner, modeller och databas&shy;kommunikation. Jag övervägde först att frångå upplägget med modellklass/<wbr>funktionsklass enligt ovan, 
                men insåg snart att detta trots allt blir enklast att hantera, då det gör det mycket smidigare att bland annat validera, filtrera och spara poster.
            </p>
            <p>
                I det här fallet finns dock en skillnad i det att <code>Product</code>-klassen innehåller egenskapen <code>categoryIds</code> 
                som i sin tur innehåller primärnycklarna för alla kategorier som produkten ifråga är med i, vilket jag nyttjar för att hämta kategori&shy;namnen i listningsvyn. 
                Denna egenskap sätts inte av PDO då den innehåller flera värden från en kopplingstabell, utan fylls upp av hämtnings&shy;metoderna i <code>ProductFunctions</code>.
            </p>
            <p>
                I övrigt blev det återigen vissa special&shy;lösningar för att generera och hantera rätt SQL-kod för alla önskade funktioner, 
                vilket komplicerades av att kategorierna ligger i en annan tabell med ett många-till-många-samband med produkterna. 
                Situationen är likartad som den med relaterade objekt i BMO-projektet i <strong>htmlphp</strong> och jag löste den på ett likartat sätt: 
                genom att ta bort och lägga till rader i kopplingstabellen inom ramarna för en transaktion när en produktpost sparas till databasen. 
                Detta sker genom en privat metod i <code>ProductFunctions</code> och om något steg i operationen fallerar rullas hela transaktionen tillbaka.
            </p>
            <p>
                En möjlig (och i viss mån önskad) utökning skulle vara att även kunna filtrera produktlistan utifrån kategori, vilket det finns en del förberedd kod för i funktionsklassen, 
                men jag kände inte att jag hade varken tid eller ork att implementera denna funktion i vyn den här gången. 
                Eftersom fritextsökningen även matchar kategorinamn kan man dock uppnå i stort sett samma resultat redan nu, så länge kategoriernas namn är någorlunda unika.
            </p>
            <p>
                Annars är ju allt detta en högst partiell lösning och det är mycket som återstår att göra i både frontend och backend samt på databasnivå, 
                men detta var ju också vad uppgiften bestod i så jag nöjer mig här för tillfället.
            </p>
            <h5>Något du vill säga om koden generellt i och kring Anax Lite?</h5>
            <p>
                Att det som sagt är många saker som är snarlika i och kring routefunktioner och vyer, men att skillnaderna fortfarande är av sådan art att det är svårt att generalisera på ett bra sätt. 
                Det blir också mycket "extrakod" när man som jag har felkontroller, validering och meddelanden i varje steg, vilket jag tycker är något som borde tryckas hårdare på – 
                säkerhet och användbarhet är bland det absolut viktigaste i en applikation, så det <em>måste</em> få ta tid och kraft i anspråk.
            </p>
        </section>
        <section id="kmom06">
            <h2>Kmom06</h2>
            <p>
                Skönt med ett lättsamt kursmoment till slut! Skillnaden mot de övriga var milsvid, kan man säga.
            </p>
            <p>
                Att få 100&nbsp;% i <code>Guess</code>-testet var inga problem, även om det krävdes lite hand&shy;påläggning för att få XAMPP:s version av PHPUnit att fungera. 
                Den versionen visade sig också vara rätt gammal och hade tydligen inte stöd för manualens variant av hur man testar undantag, 
                så eftersom jag inte iddes mecka med en uppdatering gjorde jag det testet på ett annat, mer grundläggande sätt som också fungerar bra. 
                Observera även att jag rättat några stavfel i <code>Guess</code>-klassen, så testfallen är specifika för mina filer.
            </p>
            <p>
                Koden som skapar indexen återfinns både i fristående form i <i>sql/setup-indices.sql</i> och integrerad i de tidigare skripten i samma katalog. 
                Webbshoppen har jag kort och gott lämnat därhän för tillfället, eftersom den är så pass ofärdig, men se nedan för kommentarer.
            </p>
            <h5>Var du bekant med begreppet index i databaser sedan tidigare?</h5>
            <p>
                Ja, jag har jobbat med sådana förut och känner till hur de fungerar.
            </p>
            <h5>Berätta om hur du jobbade i uppgiften om index och vilka du valde att lägga till och skillnaden före/efter.</h5>
            <p>
                Jag utgick från de <code>WHERE</code>-villkor i mina ofta körda SQL-exekverande metoder som inte berör främmande nycklar, eftersom MySQL definierar index för dessa automatiskt, 
                och såg därigenom vilka kolumner som skulle tjäna på att ha ett index, samt tittade i andra hand på <code>ORDER BY</code>-satser. 
                Eftersom jag har sortering i alla tre visningtabeller (användare, innehåll och produkter) skulle jag kunna lägga till index för <em>samtliga</em> kolumner som man kan sortera efter, 
                då denna sortering sker på databasnivå här, men det känns inte som att det skulle vara värt det – varje index kostar och detta skulle kännas som att gå över gränsen.
            </p>
            <p>
                Jag har lagt till index för följande kolumner:
            </p>
            <ol>
                <li><p>
                    <strong><code>oophp_user.username</code></strong><br>
                    Uppslag av användare görs både på ID och på användarnamn, så detta index kändes rätt självklart, 
                    och eftersom jag även kontrollerar att användarnamnen är unika när man registrerar/<wbr>redigerar en användare blev det ett 
                    <code>UNIQUE</code>-index. Dessutom kan kolumnen användas för sortering (via <code>JOIN</code>) av innehålls&shy;poster i adminvyn, så indexet har även effekt där.
                </p></li>
                <li><p>
                    <strong><code>oophp_content.type</code></strong><br>
                    Jag har funktioner för att hämta innehålls&shy;poster utifrån typ (sida, inlägg, block), vilket detta index underlättar.
                </p></li>
                <li><p>
                    <strong><code>oophp_content.published</code></strong><br>
                    Kolumnen för publicerings&shy;datum används både för selektion (att innehållet är publicerat och att datumet inte är i framtiden) 
                    och för sortering (stigande för sidlistning, fallande för blogginlägg), så även här blir det dubbel effekt.
                </p></li>
            </ol>
            <p>
                #1 och #2 gav tydliga resultat i det att <code>EXPLAIN</code> gick från att rapportera full tabell&shy;genomgång 
                till endast indexuppslag för berörda rader när man ställer frågor utifrån de aktuella kolumnerna. 
                #3 är svårare att påvisa en reell förbättring för i nuvarande tillämpning i och med att de faktiska frågor som använder detta index har fler villkor, 
                men om inte annat bör snabbheten i sorteringen ha ökat.
            </p>
            <p>
                Utöver dessa index finns redan som sagt index för alla främmande nycklar och jag hade sedan tidigare satt <code>UNIQUE</code> på <code>oophp_content<wbr>.label</code>. 
                En ytterligare kandidat för index, förutom vad som sägs om sortering ovan, skulle vara <code>oophp_category<wbr>.name</code> från webbshoppen, 
                eftersom den kolumnen kan användas både för uppslag av produkter per kategori och för alfabetisk sortering av kategorinamn vid listning, 
                men eftersom kategorierna är så få för tillfället och det heller inte finns någon frontend så kändes det inte motiverat just nu. 
                Man skulle även kunna tänka sig ett index för <code>oophp_product<wbr>.available</code>, för att snabbt kunna avgöra om en produkt är till salu eller inte.
            </p>
            <h5>Har du tidigare erfarenheter av att skriva kod som testar annan kod?</h5>
            <p>
                Om man avser enhetstest specifikt så är det väl mest det vi gjorde i föregående kurs (<a href="https://dbwebb.se/oopython"><b>oopython</b></a>) som kommer ifråga, 
                men nog har jag skrivit ett och annat testfall sådär i största allmänhet genom åren, antingen under utveckling eller under felsökning senare – 
                fast då har det oftast varit av mer manuell art, där man får tolka resultaten själv snarare än att förlita sig på <i>assertions</i>.
            </p>
            <h5>Hur ser du på begreppet enhetstestning och att skriva testbar kod?</h5>
            <p>
                Tja, vad skall jag säga... ett nödvändigt ont, kanske? Ärligt talat känns det, som ofta framförs i sammanhanget, 
                som att det kan ta <em>längre</em> tid att skriva testfallen än det tar att skriva själva koden som skall testas, 
                samt att testkoden i sig också blir längre än produktions&shy;koden – och då börjar man undra om man kanske skulle lägga kraften på att skriva bra, 
                noggrann och fungerande kod från början istället. Att t.ex. testa att, jo, sätter man en egenskap till <code>5</code> så får man verkligen <code>5</code> 
                tillbaka när man läser av den sedan känns ofta inte speciellt meningsfullt...
            </p>
            <p>
                Sedan är det kanske heller inte alltid möjligt att "skriva testbar kod" i full utsträckning, 
                då många funktioner/<wbr>användningsfall i en faktisk applikation har många delsteg med många beroenden och sidoeffekter åt många olika håll, 
                så det beror även på vad det faktiskt är man skall testa – och hur. Enhetstest räcker bara så långt.
            </p>
            <p>
                Med det sagt: ja, visst. Testa på och tänk på hur du/jag/man/ni lägger upp koden från första början, särskilt om det är flera personer som skall samarbeta.
            </p>
            <h5>Hur gick det att hitta testbar kod bland dina klasser i Anax Lite?</h5>
            <p>
                Både bra och dåligt. Många av klasserna har externa beroenden (såsom ett aktivt HTTP-anrop) och/eller innehåller metoder som <em>förändrar</em> snarare än <em>beräknar</em>, 
                vilket gör att test som skulle täcka dem hamnar i en annan kategori än rena enhetstest som det är frågan om här. 
                <code>Month</code>-klassen från kalender&shy;uppgiften var dock en solklar kandidat och eftersom jag skapat rena modellklasser utan databas&shy;koppling för användare och innehåll passade de också bra, 
                särskilt eftersom de innehåller några hjälpmetoder som går att testa. Text&shy;formateraren var också testbar, då det bara handlar om sträng&shy;omvandlingar.
            </p>
            <p>
                Kodtäckningen för de testade delarna är god, även om det totalt sett ser rätt rött ut på grund av att mycket av koden i t.ex. 
                <code>DbConnection</code> som sagt faller utanför ramarna för uppgiften. Den saknade täckningen i <code>User</code> 
                beror på att metoden ifråga utgår från dagens datum och därmed inte ger konstanta returvärden, 
                samtidigt som en mer dynamisk generering av det väntade värdet i stort sett skulle se likadan ut som funktionen den är menad att testa, vilket mest bara kändes meningslöst.
            </p>
        </section>
        <section id="kmom10">
            <h2>Kmom10</h2>
            <p>blubb</p>
        </section>
