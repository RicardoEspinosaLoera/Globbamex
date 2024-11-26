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
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class EmployeeListExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths, WithHeadings, WithEvents
{
    use Exportable;

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('file-exports.employee-list', [
            'data' => $this->data,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20, // Ajusta según sea necesario
            'C' => 25, // Ajusta según sea necesario
            'D' => 30, // Ajusta según sea necesario
            // Añadir más columnas si es necesario
        ];
    }

    public function styles(Worksheet $sheet) {
        // Aplicar estilos para encabezados y celdas con datos
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A4:I4')->getFont()->setBold(true)->getColor()->setARGB('FFFFFF');

        $sheet->getStyle('A4:I4')->getFill()->applyFromArray([
            'fillType' => 'solid',
            'rotation' => 0,
            'color' => ['rgb' => '063C93'],
        ]);

        // Desactivar líneas de cuadrícula
        $sheet->setShowGridlines(false);

        return [
            // Aplicar bordes a las celdas con datos
            'A1:I' . ($this->data['employees']->count() + 4) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }

    public function setImage($workSheet) {
        // Inserta las imágenes en la columna B para cada empleado
        $this->data['employees']->each(function($item, $index) use ($workSheet) {
            $drawing = new Drawing();
            $drawing->setName($item->name);
            $drawing->setDescription($item->name);
            $drawing->setPath(file_exists(storage_path('app/public/admin/' . $item->image)) 
                ? storage_path('app/public/admin/' . $item->image) 
                : public_path('assets/back-end/img/employee.png')
            );
            $drawing->setHeight(50); // Ajusta la altura de la imagen
            $drawing->setOffsetX(45);
            $drawing->setOffsetY(10);
            $drawing->setResizeProportional(true);

            $index += 5; // Ajuste dinámico para las filas
            $drawing->setCoordinates("B$index"); // Inserta la imagen en la columna B
            $drawing->setWorksheet($workSheet);
        });
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Alineación de celdas
                $event->sheet->getStyle('A1:I1') // Ajustar según sea necesario
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $event->sheet->getStyle('A4:I' . ($this->data['employees']->count() + 4)) // Ajustar según sea necesario
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $event->sheet->getStyle('A2:I3') // Ajustar según sea necesario
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Combinación de celdas
                $event->sheet->mergeCells('A1:I1'); // Encabezado principal
                $event->sheet->mergeCells('A2:B2');
                $event->sheet->mergeCells('C2:I2');
                $event->sheet->mergeCells('A3:B3');
                $event->sheet->mergeCells('C3:I3');

                // Ajuste de la altura de las filas
                $event->sheet->getRowDimension(2)->setRowHeight(60);
                $event->sheet->getRowDimension(1)->setRowHeight(30);
                $event->sheet->getRowDimension(3)->setRowHeight(30);
                $event->sheet->getRowDimension(4)->setRowHeight(30);
                $event->sheet->getDefaultRowDimension()->setRowHeight(50);

                // Insertar imágenes después de definir la hoja de cálculo
                $workSheet = $event->sheet->getDelegate();
                $this->setImage($workSheet);
            },
        ];
    }

    public function headings(): array
    {
        return [
            'Employee ID', 'Image', 'Name', 'Position', 'Department', 'Email', 'Phone', 'Hire Date', 'Salary'
        ];
    }
}
