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
                Ännu ett stort moment, som kändes ännu större eftersom jag hade mindre tid till mitt förfogande på grund av en skidresa (som var väl värd tiden).
            </p>
            <p>
                Jag började med att bestämma databasschemat och planerade redan från start för att integrera uppgift 1 och 2 med varandra. 
                Min användartabell innehåller därför attributet <code>level</code> som fungerar som behörighetsflagga för administrationsdelen och av samma anledning har jag ingen 
                <i>sql/setup-admin.sql</i>, utan allt som behövs för bägge uppgifterna finns i <i>sql/setup-user.sql</i>. Skriptet definierar fyra användare från start, 
                varav en superadministratör (se nedan), en administratör och två vanliga användare.
            </p>
            <p>
                Användarna registreras med ett fåtal uppgifter och blir kanske inte jätteintressanta, 
                men det är enkelt att utöka det hela om man vill då grunden nu är lagd och resten bara är anpassningar. 
                Som föreslagit har jag begränsat lagringen av profilbilder till URL:er, men detta gör det också enkelt att implementera en uppladdnings&shy;funktion senare, 
                då dataformatet med fördel kan behållas även i det fallet.
            </p>
            <p>
                Jag bestämde mig också tidigt för att lägga in inloggningen i navigationslisten, vilket jag löste genom några <code>if</code>-satser i min <i>config/navbar.php</i> 
                som bygger upp olika menystrukturer beroende på om man är inloggad eller inte, samt om man är administratör eller inte. 
                Är man inte inloggad kan man gå till registreringssidan eller inloggningssidan, 
                men om man är inloggad visas användarnamnet intill en miniatyr av profilbilden och undermenyn ger tillgång till användarprofilen samt eventuellt adminpanelen. 
                Detta upplägg gjorde det enkelt att få plats med alla menyval på ett smidigt sätt, inklusive markering av aktuell avdelning/<wbr>sida.
            </p>
            <p>
                Jag har organiserat alla mina användarrelaterade routefunktioner i <i>config/routes/user.php</i>, där sökvägarna följer en genomtänkt struktur, 
                och vyerna ligger i <i>views/user</i>. Efter att inloggning skett sparas användarens ID (primärnyckel) 
                i sessionen och alla sökvägar med behörighetskrav kontrollerar motsvarande användares nivå i alla steg, 
                så att man t.ex. inte kan skaffa sig otillbörlig åtkomst genom att skicka egenskapade <code>POST</code>-anrop. Se vidare under frågorna nedan för mer om kodens upplägg.
            </p>
            <p>
                I kakan valde jag att lagra tidpunkt för när den senaste inloggningen skedde (d.v.s. inte senaste <em>besöket</em>). 
                Detta är väl kanske något som borde sparas direkt i databasen om det verkligen är intressant och skall användas till något, 
                så det är med här mest bara för att demonstrera hur det fungerar.
            </p>
            <p>
                I adminpanelen listas alla användare tillsammans med fyra typer av UI-kontroller: en sökruta som matchar fälten användarnamn, födelsedatum och e-post 
                (fritext, icke skift&shy;läges&shy;känsligt), en inställning för hur många poster som skall visas per sida, sortering på kolumnrubriker och slutligen framåt- 
                och bakåtknappar för att bläddra mellan sidorna om det finns flera. Härifrån kan man också skapa en ny användare. 
                Behörighetsnivåerna är upplagda så att man endast har rättigheter att ändra användarposter med samma eller lägre nivå än man själv har, 
                så det är bara superadministratörer (nivå 2) som kan lägga till och redigera andra superadministratörer. Man kan dock aldrig ändra sin egen nivå, eller ta bort sitt eget konto.
            </p>
            <p>
                Just kravet om borttagning är lite tveksamt då man sällan i en verklig tillämpning faktiskt <em>raderar</em> poster, eftersom det ofta leder till problem med referensintegritet, 
                men i och med att dessa användare inte är knutna till något speciellt här har jag ändå implementerat äkta <code>DELETE FROM</code>-funktionalitet – 
                fast med ett bekräftelsesteg för att vara på den säkra sidan. Det finns dock även ett attribut <code>active</code> som används för att spärra ett konto, 
                vilket ofta uppnår samma effekt. Använd <i>admin</i>/<wbr><i>correcthorsebatterystaple</i> för att testa administratörs&shy;kontot.
            </p>
            <p>
                Utöver momentets uppgifter har jag också byggt om en del av koden för att underlätta för mig själv, samt infört riktiga docblock-kommentarer. 
                Några smärre uppdateringar i stilsättningen har det också blivit, där jag bl.a. gått över till flexboxlayout i vissa delar samt har gjort vad jag kunnat för att alla nya 
                (och gamla) vyer skall fungera så bra som möjligt responsivt, även om just användartabellen i adminpanelen (se nedan) som vanligt blir en kompromiss.
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
                Posterna hämtas som anonyma objekt som standard, men man kan även skicka med ett klassnamn för att instantiera en specifik klass, vilket jag utnyttjar för användarobjekten. 
                Uppkopplings&shy;uppgifterna finns i en fil <i>config/db.php</i> som inte ingår i repot, men det finns en <i>config/db-example.php</i> 
                som illustrerar hur den är upplagd och automatiskt anpassar sig till lokal respektive publicerad miljö.
            </p>
            <p>
                För användarsystemet har jag dels en <code>User</code>-klass som motsvarar databastabellen, plus några hjälpmetoder och konstanter, 
                och dels en <code>Functions</code>-klass (i samma namnrymd) som innehåller metoder för att hantera tillhörande databas&shy;operationer och datavalidering. 
                Detta gjorde det enkelt att skriva routefunktionerna, då dessa kunde hållas på en hög nivå utan att veta något om hur databasen är uppbyggd 
                (men det finns fortfarande möjlighet att prata direkt med databasen via <code>$app->db</code> om man ändå skulle vilja det).
            </p>
            <p>
                Jag använder samma formulär (vy) för att skapa och redigera användare, för både gäster, vanliga användare och administratörer, 
                där respektive routefunktion sätter olika variabler för att styra vad som visas och vart uppgifterna skickas. Indatan valideras sedan med hjälp av funktionsklassen ovan, 
                där jag fick stänga av några PHPMD-varningar som kort och gott inte är relevanta i sammanhanget – 
                jag vill ha all validering på samma ställe för att det skall bli mer lätthanterligt och det blir rätt många olika fall som skall täckas in för att ge användaren informativa felmeddelanden, 
                som skrivs ut i en lista i vyn. <code>Session::getOnce()</code> används för att skicka meddelanden mellan vyerna, för både fel eller bekräftelser.
            </p>
            <p>
                Slutligen lade jag även till en <code>Cookie</code>-klass av samma stuk som <code>Session</code> i ramverket (<code>$app->cookie</code>), då jag aldrig gjorde det i förra momentet.
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
                även om just Anax Lite inte nödvändigtvis är att betrakta som "allmänt gångbart" ute i det vilda går grundkomponenterna och arkitekturen igen, 
                så den ökade vanan kommer in även där.
            </p>
        </section>
        <section id="kmom04">
            <h2>Kmom04</h2>
            <p>blubb</p>
        </section>
        <section id="kmom05">
            <h2>Kmom05</h2>
            <p>blubb</p>
        </section>
        <section id="kmom06">
            <h2>Kmom06</h2>
            <p>blubb</p>
        </section>
        <section id="kmom10">
            <h2>Kmom10</h2>
            <p>blubb</p>
        </section>
