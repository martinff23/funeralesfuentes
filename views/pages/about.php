<main class="about">
    <h2 class="page-main__heading"><?php echo $title;?></h2>
    <?php if($start) { ?>
        <div class="about__grid">
            <div class="about__image">
                <picture>
                    <source srcset="build/img/mission_about.avif" type="image/avif">
                    <source srcset="build/img/mission_about.webp" type="image/webp">
                    <img loading="lazy" src="build/img/mission_about.png" width="20" height="30" alt="Misión de Funerales Fuentes">
                </picture>
            </div>
            <div class="about__image">
                <picture>
                    <source srcset="build/img/vision_about.avif" type="image/avif">
                    <source srcset="build/img/vision_about.webp" type="image/webp">
                    <img loading="lazy" src="build/img/vision_about.png" width="20" height="30" alt="Visión de Funerales Fuentes">
                </picture>
            </div>
            <div class="about__image">
                <picture>
                    <source srcset="build/img/believes_about.avif" type="image/avif">
                    <source srcset="build/img/believes_about.webp" type="image/webp">
                    <img loading="lazy" src="build/img/believes_about.png" width="20" height="30" alt="Creencias de Funerales Fuentes">
                </picture>
            </div>
            <div class="about__image">
                <picture>
                    <source srcset="build/img/values_about.avif" type="image/avif">
                    <source srcset="build/img/values_about.webp" type="image/webp">
                    <img loading="lazy" src="build/img/values_about.png" width="20" height="30" alt="Valores de Funerales Fuentes">
                </picture>
            </div>
        </div>
    <?php } else { ?>
        <div class="about__grid">
            <div class="about__image">
                <picture>
                    <source srcset="build/img/mission_about.avif" type="image/avif">
                    <source srcset="build/img/mission_about.webp" type="image/webp">
                    <img loading="lazy" src="build/img/mission_about.png" width="20" height="30" alt="Misión de Funerales Fuentes">
                </picture>
            </div>
            <div class="about__content">
                <p class="about__title">
                    Nuestra misión
                </p>
                <!-- <p class="about__text">
                Servicios funerarios dignos, personalizados, innovadores, ecológicos, accesibles e inclusivos al alcance de todos
                </p> -->
                <p class="about__text">
                    <ul>
                        <li class="about__list">“Servicios funerarios” - nuestro trabajo y razón de ser</li>
                        <li class="about__list">“dignos” - sin importar las causas del deceso ni el presupuesto empleado, se dará la máxima calidad de servicio a todos nuestros clientes</li>
                        <li class="about__list">“personalizados” - a pesar de que los servicios funerarios se basan en procesos estandarizados, se dará acompañamiento y atención específico a cada detalle solicitado por los clientes para sobrellevar el trago amargo del adiós</li>
                        <li class="about__list">“innovadores” - la primordial apuesta será la investigación y el desarrollo para ofrecer las soluciones más innovadoras del mercado</li>
                        <li class="about__list">“ecológicos” - creemos en que la muerte puede ser el inicio de la vida, y que podemos hacer un impacto positivo en la naturaleza a la par de dar un último adiós de calidad a nuestros seres queridos</li>
                        <li class="about__list">“accesibles” - nuestro modelo de negocio permitirá establecer tarifas y precios justos y a disposición de cualquier persona, sin importar su condición socioeconómica y sin comprometer la rentabilidad del negocio</li>
                        <li class="about__list">“inclusivos” - contaremos con una amplia gama de productos y servicios para brindar el último adiós de seres queridos humanos (sin importar sus condiciones biopsicosociales) y mascotas</li>
                        <li class="about__list">“al alcance de todos” – somos un negocio que no discrimina ni limita su oferta de valor para nadie. Estamos para apoyar a todos en el momento más complicado y bello del ciclo de la vida</li>
                    </ul>
                </p>
            </div>
            <div class="about__image">
                <picture>
                    <source srcset="build/img/vision_about.avif" type="image/avif">
                    <source srcset="build/img/vision_about.webp" type="image/webp">
                    <img loading="lazy" src="build/img/vision_about.png" width="20" height="30" alt="Visión de Funerales Fuentes">
                </picture>
            </div>
            <div class="about__content">
                <p class="about__title">
                    Nuestra visión
                </p>
                <!-- <p class="about__text">
                Aspiramos a ser la agencia funeraria líder en servicios funerarios ecológicos e inclusivos, alcanzando diversas comunidades y transformando permanentemente la forma de honrar la vida y memoria de los seres queridos, tanto humanos como mascotas
                </p> -->
                <p class="about__text">
                    <ul>
                        <li class="about__list">“Aspiramos a ser la agencia funeraria líder en servicios funerarios ecológicos e inclusivos” – queremos ser estandarte de la transición, de funerales convencionales a funerales ecológicos. Además, queremos que todas las personas tengan acceso a este tipo de servicios funerarios sin importar sus condiciones biopsicosociales</li>
                        <li class="about__list">“alcanzando diversas comunidades” – buscamos concretar un plan de expansión del negocio en los próximos años</li>
                        <li class="about__list">“transformando permanentemente la forma de honrar la vida y memoria de los seres queridos, tanto humanos como mascotas” – queremos que el modelo de negocio permita que la innovación sea nuestra práctica habitual, incorporando las más recientes tendencias en cuanto a servicios funerarios. De este modo, buscamos que el doliente perciba un homenaje a la vida y trascendencia de su ser querido y pueda llevar el proceso del adiós de una forma más serena y en paz</li>
                    </ul>
                </p>
            </div>
            <div class="about__image">
                <picture>
                    <source srcset="build/img/believes_about.avif" type="image/avif">
                    <source srcset="build/img/believes_about.webp" type="image/webp">
                    <img loading="lazy" src="build/img/believes_about.png" width="20" height="30" alt="Creencias de Funerales Fuentes">
                </picture>
            </div>
            <div class="about__content">
                <p class="about__text">
                    Nuestras creencias
                </p>
                <p class="about__title">
                    <ul>
                        <li class="about__list">Dignidad al último adiós - Creemos que cada despedida debe ser un acto de amor y respeto, brindando a cada persona un homenaje digno que honre su vida</li>
                        <li class="about__list">Acompañamos con calidez y empatía - Acompañamos a las familias con empatía y calidez, asegurándonos de que reciban el apoyo necesario en momentos difíciles</li>
                        <li class="about__list">Celebramos la vida, respetamos el legado y honramos la muerte - Creemos que tanto la vida como el proceso de despedida tienen un profundo significado, por lo que ofrecemos un servicio que honra ambas situaciones</li>
                        <li class="about__list">Competimos y ganamos profesionalmente - El sector funerario nos da oportunidades a distintas agencias funerarias para poder ejecutar nuestra misión. Por lo tanto, no creemos en la competencia desleal por adquisición de clientes, en cambio, creemos que, en un ambiente pacífico y profesional, todos podemos ejecutar este hermoso trabajo y esta bella misión de vida</li>
                        <li class="about__list">Existe vida después de la muerte - A través de opciones ecológicas, como la reforestación con cenizas o procesos sostenibles, promovemos que la memoria de cada persona continúe a través de la naturaleza</li>
                        <li class="about__list">Apostamos por lo sustentable - Nos comprometemos con prácticas ecológicas que reduzcan nuestro impacto ambiental, ofreciendo alternativas sustentables en el sector funerario. Además, la estrategia del negocio está diseñada para perdurar con el paso de los años</li>
                        <li class="about__list">Apoyamos sin barreras - Nuestros servicios están diseñados para ser accesibles e inclusivos, brindando apoyo a todas las familias sin distinción</li>
                    </ul>
                </p>
            </div>
            <div class="about__image">
                <picture>
                    <source srcset="build/img/values_about.avif" type="image/avif">
                    <source srcset="build/img/values_about.webp" type="image/webp">
                    <img loading="lazy" src="build/img/values_about.png" width="20" height="30" alt="Valores de Funerales Fuentes">
                </picture>
            </div>
            <div class="about__content">
                <p class="about__text">
                    Nuestros valores
                </p>
                <p class="about__title">
                    <ul>
                        <li class="about__list">Empatía - Ponemos el corazón en cada servicio, brindando apoyo genuino a quienes nos necesitan, tal como si nosotros fuésemos los contratantes del servicio funerario, brindando la calidad de servicio y atención que nos gustaría recibir</li>
                        <li class="about__list">Respeto - Honramos la vida y las creencias de cada familia, ofreciendo opciones personalizadas y diversas, respetando los límites de cada persona y entendiendo las situaciones y momentos que acontezcan</li>
                        <li class="about__list">Responsabilidad - Cumplimos con cabalidad nuestra palabra y los acuerdos celebrados al momento de la adquisición del servicio funerario, buscando siempre brindar la máxima calidad posible y mitigando la probabilidad de error e insatisfacción</li>
                        <li class="about__list">Compromiso - Nos dedicamos a brindar un servicio de calidad, con integridad y profesionalismo en cada una de nuestras acciones</li>
                        <li class="about__list">Innovación - Buscamos permanentemente nuevas formas de brindar un servicio significativo y adaptado a las necesidades de cada momento</li>
                        <li class="about__list">Inclusión - Creemos que cada ser, humano o mascota, merece un adiós digno y especial</li>
                        <li class="about__list">Sustentabilidad - Promovemos funerales ecológicos que minimicen el impacto ambiental y que además sean soluciones que perduren con el paso del tiempo</li>
                    </ul>
                </p>
            </div>
        </div>
    <?php } ?>
</main>