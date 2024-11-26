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

class CouponListExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths, WithHeadings, WithEvents
{
    use Exportable;

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('file-exports.coupon-list', [
            'data' => $this->data,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 25,
            'C' => 20, // Puedes ajustar el ancho de las demás columnas según sea necesario
            // Añade más columnas según las necesidades de tu archivo
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplica un estilo simple a las celdas de la cabecera
        $sheet->getStyle('A1:M1')->getFont()->setBold(true);
        $sheet->getStyle('A3:M3')->getFont()->setBold(true);
        
        // Color de fondo para la cabecera
        $sheet->getStyle('A3:M3')->getFill()->applyFromArray([
            'fillType' => 'solid',
            'color' => ['rgb' => '063C93'],
        ]);

        // Configuración de alineación
        $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:M1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Estilo de bordes
        $sheet->getStyle('A1:M' . ($this->data['coupon']->count() + 3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Fusión de celdas para el título
                $sheet->mergeCells('A1:M1');
                
                // Alineación
                $sheet->getStyle('A1:M1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Definir la altura de las filas
                $sheet->getDefaultRowDimension()->setRowHeight(30);

                // Alineación de las celdas de datos
                $sheet->getStyle('A2:M' . ($this->data['coupon']->count() + 2))
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }

    public function headings(): array
    {
        // Define tus encabezados aquí
        return [
            'Código',
            'Nombre',
            'Descripción',
            'Fecha',
            // Agrega más encabezados según los datos que estés exportando
        ];
    }
}
