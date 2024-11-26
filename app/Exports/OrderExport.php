<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OrderExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths, WithHeadings, WithEvents
{
    use Exportable;

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('file-exports.order-export', [
            'data' => $this->data,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            // Ajusta más columnas si es necesario
        ];
    }

    public function styles(Worksheet $sheet) {
        // Estilos básicos para encabezado y contenido
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A4:P4')->getFont()->setBold(true)->getColor()
            ->setARGB('FFFFFF');
        
        // Estilo de fondo para encabezados
        $sheet->getStyle('A4:P4')->getFill()->applyFromArray([
            'fillType' => 'solid',
            'rotation' => 0,
            'color' => ['rgb' => '063C93'],
        ]);

        // Colorear las columnas específicas
        $sheet->getStyle('P5:P'.$this->data['orders']->count() + 4)->getFill()->applyFromArray([
            'fillType' => 'solid',
            'rotation' => 0,
            'color' => ['rgb' => 'D6BC00'],
        ]);

        $sheet->getStyle('O5:O'.$this->data['orders']->count() + 4)->getFill()->applyFromArray([
            'fillType' => 'solid',
            'rotation' => 0,
            'color' => ['rgb' => 'FFF9D1'],
        ]);

        // Desactivar las líneas de la cuadrícula
        $sheet->setShowGridlines(false);

        // Aplicar bordes a las celdas con datos
        return [
            'A1:P'.$this->data['orders']->count() + 4 => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Alinear texto horizontal y verticalmente en celdas específicas
                $event->sheet->getStyle('A1:P1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $event->sheet->getStyle('A4:P'.$this->data['orders']->count() + 4)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $event->sheet->getStyle('A2:P3')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Combinación de celdas para encabezados
                $event->sheet->mergeCells('A1:P1'); // Título principal
                $event->sheet->mergeCells('A2:B2');
                $event->sheet->mergeCells('C2:P2');
                $event->sheet->mergeCells('A3:B3');
                $event->sheet->mergeCells('C3:P3');
                
                // Condición para combinar celdas basada en el estado de las órdenes
                if($this->data['order_status'] != 'all') {
                    $event->sheet->mergeCells('A2:B3');
                    $event->sheet->mergeCells('C2:P3');
                    $event->sheet->mergeCells('O4:P4');

                    // Combinación dinámica para las órdenes
                    $this->data['orders']->each(function($item, $index) use ($event) {
                        $index += 5; // Ajuste dinámico de la fila
                        $event->sheet->mergeCells("O$index:P$index");
                    });
                }

                // Ajustar la altura de las filas
                $event->sheet->getRowDimension(2)->setRowHeight(110); // Ajustar la fila 2
                $event->sheet->getDefaultRowDimension()->setRowHeight(30); // Altura predeterminada para otras filas
            },
        ];
    }

    public function headings(): array
    {
        return [
            'Order ID', 'Customer', 'Seller', 'Total Quantity', 'Total Price', 'Order Status', 'Order Date',
            'Payment Method', 'Delivery Type', 'Shipment ID', 'Tracking Number', 'Warehouse', 'Paid', 'Processed',
            'Shipment Status'
        ];
    }
}
