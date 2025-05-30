<?php
class ContratoWeb extends Contrato {
    private $porcentaje_descuento;

    public function __construct($fecha_inicio, $fecha_vencimiento, $plan, $ref_cliente) {
        parent :: __construct($fecha_inicio, $fecha_vencimiento, $plan, $ref_cliente);
        $this->porcentaje_descuento = 10;
    }

    public function __toString() {
        $cadena = ( parent::__toString() . 
                    "\nPorcentaje de descuento: " . $this->getPorcentaje_descuento() );
        return $cadena;
    }

    public function calcularImporte() {
        $plan = parent :: getPlan();
        $canales = $plan->getColeccion_canales();
        $importe_plan = $plan->getImporte();
        $importe = $importe_plan;
        foreach ($canales as $unCanal) {
            $importe_canal = $unCanal->getImporte();
            $importe += $importe_canal; 
        }
        $pocentaje = $this->getPorcentaje_descuento();
        $importe_final = $importe - (($importe * $porcentaje)/100);
        return $importe_final;
    }
}
?>