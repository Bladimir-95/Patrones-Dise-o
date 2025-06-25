<?php
    /*
    //FACTORY
    interface Iataque {
        function powerup();
    }

    class zombie implements Iataque{
        function powerup(){
            echo "Manipulando la gravedad...";
        }
    }
    
    class esqueleto implements Iataque{
        function powerup(){
            echo "Lanzando fuego... 🔥";
        }
    }

    class character {
        public static function createCharacter($dificultad) {
            return match ($dificultad) {
                "nivel facil" => new esqueleto(),
                "nivel dificil" => new zombie(),
                default => throw new Exception("No existe este nivel")
            };
        }
    }

    $character = character::createCharacter('nivel facil');
    $character->powerup();*/

    /*
    //DECORATOR
    interface IPersonaje{
        public function descripcion();
    }

    class Soldado implements IPersonaje{
        public function descripcion(){
            return "Soldado";
        }
    }

    class Policia implements IPersonaje{
        public function descripcion(){
            return "Policia";
        }
    }

    abstract class ArmaDecorator implements IPersonaje{
        protected IPersonaje $personaje;

        public function __construct(IPersonaje $personaje){
            $this->personaje = $personaje;
        }

        public function descripcion(){
            
        }
    }
    
    class Ametralladora extends ArmaDecorator{
        
        public function descripcion(){
            return $this->personaje->descripcion() .  " Con ametralladora";
        }
    }

    class Escpeta extends ArmaDecorator{
        
        public function descripcion(){
            return $this->personaje->descripcion() .  " Con escopeta";
        }
    }

    $soldado = new Soldado();
    $policia = new Policia();

    $soldadoConAme = new Ametralladora($soldado);
    $policiaConEscop = new Escpeta($policia);
    
    echo $soldadoConAme->descripcion();
    echo $policiaConEscop->descripcion();*/

    /*
    //ADAPTER
    interface Archivo {
    public function abrir();
}


class ArchivoWindows10 implements Archivo {
    private $nombre;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }

    public function abrir(){
        echo "Abriendo archivo moderno: {$this->nombre}" . PHP_EOL;
    }
}
 
// Clase de archivo de Windows 7 incompatible con Windows 10 directamente
class ArchivoWindows7 {
    private $nombre;

    public function __construct(string $nombre) {
        $this->nombre = $nombre;
    }

    public function abrirViejo(){
        echo "Abriendo archivo antiguo: {$this->nombre}" . PHP_EOL;
    }
}

//Adapta el archivo para leerlo con widows10
class AdaptadorArchivoWindows7 implements Archivo {
    private $archivoWindows7;

    public function __construct(ArchivoWindows7 $archivoWindows7) {
        $this->archivoWindows7 = $archivoWindows7;
    }

    public function abrir() {
        $this->archivoWindows7->abrirViejo();
    }
}


$archivo10 = new ArchivoWindows10("documento_moderno.docx");
$archivo10->abrir();

$archivo7 = new ArchivoWindows7("documento_antiguo.doc");
$archivoAdaptado = new AdaptadorArchivoWindows7($archivo7);
$archivoAdaptado->abrir();
*/

//STRATEGY
interface EstrategiaSalida {
    public function mostrar($mensaje);
}


class SalidaConsola implements EstrategiaSalida {
    public function mostrar($mensaje){
        echo "Consola: " . $mensaje . PHP_EOL;
    }
}


class SalidaJSON implements EstrategiaSalida {
    public function mostrar($mensaje){
        echo json_encode(["mensaje" => $mensaje], JSON_PRETTY_PRINT) . PHP_EOL;
    }
}


class SalidaArchivoTXT implements EstrategiaSalida {
    private $archivo;

    public function __construct(string $archivo = "salida.txt") {
        $this->archivo = $archivo;
    }

    public function mostrar($mensaje){
        file_put_contents($this->archivo, $mensaje . PHP_EOL, FILE_APPEND);
        echo "Mensaje guardado en {$this->archivo}" . PHP_EOL;
    }
}


class MensajeContexto {
    private $estrategia;

    public function __construct(EstrategiaSalida $estrategia) {
        $this->estrategia = $estrategia;
    }

    public function setEstrategia(EstrategiaSalida $estrategia): void {
        $this->estrategia = $estrategia;
    }

    public function mostrarMensaje(string $mensaje): void {
        $this->estrategia->mostrar($mensaje);
    }
}

$mensaje = "Holiwis, como andis XD";

$contexto = new MensajeContexto(new SalidaConsola());
$contexto->mostrarMensaje($mensaje);

$contexto->setEstrategia(new SalidaJSON());
$contexto->mostrarMensaje($mensaje);

$contexto->setEstrategia(new SalidaArchivoTXT());
$contexto->mostrarMensaje($mensaje);
?>