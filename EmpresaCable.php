<?php
class EmpresaCable {
    private $coleccion_planes;
    private $coleccion_canales;
    private $coleccion_clientes;
    private $contratos_planes;

    public function __construct() {
        $this->coleccion_planes = [];
        $this->coleccion_canales = [];
        $this->coleccion_clientes = [];
        $this->contratos_planes = [];
    }

    public function __toString() {

    }

    public function incorporarPlan($NuevoPlan) {
      
    }

    public function buscarContrato($tipoDocu, $nroDocu) {
        $coleccionContratos = $this->getContratos_clientes();
        $contrato = null;
        foreach ($coleccionContratos as $unContrato) {
            $refCliente = $unContrato->getRef_cliente();
            $tipo = $refCliente->getTipo_documento();
            $numero = $refCliente->getNumero_documento();
            if ($tipo==$tipoDocu && $nroDocu == $numero) {
                $contrato = $unContrato;
            }
        }
        return $contrato;
    }

    public function incorporarContrato($plan, $refCliente, $fechaInicio, $fechaVencimiento, $booleano) {
        $nroDocu = $refCliente->getNumero_documento();
        $tipoDocu = $refCliente->getTipoDocumento();
        $coleccionContratos = $this->getContratos_planes();

        $contrato_existente = buscarContrato($tipoDocu, $nroDocu);

        if ($contrato_existente != null) {
            $estado = $contrato_existente->getEstado();
            if ($estado != "suspendido") {
                $contrato_existente->setEstado("suspendido");
            }
        } 

        if ($booleano == true) {
            $nuevoContrato = new ContratoWeb($fechaInicio, $fechaVencimiento, $plan, $refCliente);
            array_push($coleccionContratos, $nuevoContrato);
            $this->setContratos_planes($contratos_planes);
        } 

        if ($booleano == false) {
            $nuevoContrato = new Contrato($fechaInicio, $fechaVencimiento, $plan, $refCliente);
            array_push($coleccionContratos, $nuevoContrato);
            $this->setContratos_planes($contratos_planes);
         }       
    } 

    public function retornarPromImporteContratos($codigo_plan) {
        $promedio = 0;
        $coleccion_contratos = $this->getContratos_planes();
        $cant = 0;
        $total_importes = 0;
        foreach ($coleccion_contratos as $unContrato) {
            $unPlan = $unContrato->getPlan();
            $codigo = $unPlan->getCodigo();
            if ($codigo == $codigo_plan) {
                $importe = $unContrato->getCosto();
                $total_importes += $importe;
                $cant +=1;
            }
        }
        if ($cant != 0) {
            $promedio = $total_importes / $cant;
        }
        return $promedio;
    }

    public function pagarContrato($codigoContrato) {
        $contratos = $getContratos_planes();
        $importe_final = 0;
        $bandera = false;
        $i = 0;
        $canContratos = count($contratos);
        while ($i<$canContratos && !$bandera) {
            $unContrato = $contratos[$i];
            $codigo = $unContrato->getCodigo();
            if ($codigo == $codigoContrato) {
                $unContrato->actualizarEstadoContrato();
                $importe_final = $unContrato->calcularImporte();
                $bandera = true;
            }
            $i++;
        }
        return $importe_final;
    }
}
?>