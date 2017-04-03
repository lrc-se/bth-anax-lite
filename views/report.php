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
                Sökvägen <a href="<?= $app->url->create('server') ?>"><code>/server</code></a> returnerar PHP-variabeln <code>$_SERVER</code> i JSON-format.
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
            <p>blubb</p>
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
