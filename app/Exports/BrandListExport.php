<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\AfterSheet;

class BrandListExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths, WithHeadings, WithEvents
{
    use Exportable;

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('file-exports.brand-list', [
            'data' => $this->data,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            // Ajusta los anchos de columnas según sea necesario
            'B' => 25,
            'C' => 20,
            'D' => 15,
            'E' => 15,
            'F' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A4:F4')->getFont()->setBold(true)->getColor()->setARGB('FFFFFF');
        
        $sheet->getStyle('A4:F4')->getFill()->applyFromArray([
            'fillType' => 'solid',
            'rotation' => 0,
            'color' => ['rgb' => '063C93'],
        ]);

        $sheet->getStyle('F5:F' . ($this->data['brands']->count() + 4))->getFill()->applyFromArray([
            'fillType' => 'solid',
            'rotation' => 0,
            'color' => ['rgb' => 'FFF9D1'],
        ]);

        $sheet->setShowGridlines(false);

        // Aplicar bordes a todas las celdas con datos
        $sheet->getStyle('A1:F' . ($this->data['brands']->count() + 4))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        return [];
    }

    public function setImage(Worksheet $workSheet)
    {
        $this->data['brands']->each(function ($item, $index) use ($workSheet) {
            if (file_exists(storage_path('app/public/brand/' . $item->image))) {
                $drawing = new Drawing();
                $drawing->setName($item->name);
                $drawing->setDescription($item->name);
                $drawing->setPath(storage_path('app/public/brand/' . $item->image));
                $drawing->setHeight(50);
                $drawing->setOffsetX(40);
                $drawing->setOffsetY(7);
                $drawing->setResizeProportional(true);
                $index += 5; // Ajuste para la fila correcta
                $drawing->setCoordinates("B$index");
                $drawing->setWorksheet($workSheet);
            }
        });
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:F1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $event->sheet->getStyle('A4:F' . ($this->data['brands']->count() + 4))
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Combinación de celdas
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->mergeCells('A2:B2');
                $event->sheet->mergeCells('C2:F2');
                $event->sheet->mergeCells('A3:B3');
                $event->sheet->mergeCells('C3:F3');

                // Ajustar las dimensiones de las filas
                $event->sheet->getRowDimension(2)->setRowHeight(60);
                $event->sheet->getRowDimension(1)->setRowHeight(30);
                $event->sheet->getRowDimension(3)->setRowHeight(30);
                $event->sheet->getRowDimension(4)->setRowHeight(30);
                $event->sheet->getDefaultRowDimension()->setRowHeight(50);

                // Insertar imágenes
                $workSheet = $event->sheet->getDelegate();
                $this->setImage($workSheet);
            },
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Image',
            'Brand Name',
            'Category',
            'Active Products',
            'Total Sales',
        ];
    }
}
