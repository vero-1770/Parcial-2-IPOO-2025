<?php 
class Contrato {
    private $fecha_inicio;
    private $fecha_vencimiento;
    private $plan;
    private $estado;
    private $costo;
    private $renovable;
    private $ref_cliente;   

    public function __construct() {

    }

    public function __toString() {

    }

    public function actualizarEstadoContrato() {
        $dias_vencido = diasContratoVencido($contrato); 
        $estado = $this->getEstado();

        if ($dias_vencido == 0) {
            $estado = "Al dia";
            $this->setEstado();
        }

        if ($dias_vencido > 0) {
            if ($dias_vencido <= 10) {
                $estado = "Moroso";
                $this->setEStado($estado);
            }
            if ($dias_vencido > 10) {
                $estado = "Suspendido";
                $this->setEStado($estado);
            }
        }
    }

    public function calcularImporte() {
        $plan = $this->getPlan();
        $canales = $plan->getColeccion_canales();
        $importe_plan = $plan->getImporte();
        $importe_final = $importe_plan;
        foreach ($canales as $unCanal) {
            $importe_canal = $unCanal->getImporte();
            $importe_final += $importe_canal; 
        }
        return $importe_final;
    }


}
?>