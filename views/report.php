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
            <p>blubb</p>
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
