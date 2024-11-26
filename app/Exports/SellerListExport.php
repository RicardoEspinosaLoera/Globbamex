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

class SellerListExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths, WithHeadings, WithEvents
{
    use Exportable;
    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('file-exports.seller-list', [
            'data' => $this->data,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
        ];
    }

    public function styles(Worksheet $sheet) {
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A4:J4')->getFont()->setBold(true)->getColor()
              ->setARGB('FFFFFF');

        $sheet->getStyle('A4:J4')->getFill()->applyFromArray([
            'fillType' => 'solid',
            'rotation' => 0,
            'color' => ['rgb' => '063C93'],
        ]);

        $sheet->getStyle('H5:J'.$this->data['sellers']->count() + 4)->getFill()->applyFromArray([
            'fillType' => 'solid',
            'rotation' => 0,
            'color' => ['rgb' => 'FFF9D1'],
        ]);

        $sheet->setShowGridlines(false);

        return [
            'A1:J'.$this->data['sellers']->count() + 4 => [
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
        $this->data['sellers']->each(function($item, $index) use($workSheet) {
           /* $imagePath = file_exists(storage_path('app/public/shop/' . $item?->shop->image)) 
                ? storage_path('app/public/shop/' . $item?->shop->image) 
                : public_path('assets/back-end/img/seller_sale.png');*/

                $workSheet->getColumnDimension('B')->setWidth(20); // Puedes ajustar el valor 20 según sea necesario
                $drawing = new Drawing();
                $drawing->setName($item->f_name);
                $drawing->setDescription($item->f_name);
                $drawing->setPath(file_exists(storage_path('app/public/shop/'.$item?->shop->image))? storage_path('app/public/shop/'.$item?->shop->image) : public_path('assets/back-end/img/seller_sale.png'));
                $drawing->setHeight(50);
                $drawing->setOffsetX(30);
                $drawing->setOffsetY(7);
                $drawing->setResizeProportional(true);
                $drawing->setCoordinates('B' . ($index + 5));
                $drawing->setWorksheet($workSheet);
            
        });
        $workSheet->getColumnDimension('B')->setAutoSize(false); // Desactivar autosize
        /*$this->data['sellers']->each(function($item,$index) use($workSheet) {
            $drawing = new Drawing();
            $drawing->setName($item->f_name);
            $drawing->setDescription($item->f_name);
            $drawing->setPath(file_exists(storage_path('app/public/shop/'.$item?->shop->image))? storage_path('app/public/shop/'.$item?->shop->image) : public_path('assets/back-end/img/seller_sale.png'));
            $drawing->setHeight(50);
            $drawing->setOffsetX(30);
            $drawing->setOffsetY(7);
            $drawing->setResizeProportional(true);
            $index+=5;
            $drawing->setCoordinates("B$index");
            $drawing->setWorksheet($workSheet);

        });*/
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:J1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $event->sheet->getStyle('A4:J'.$this->data['sellers']->count() + 4)
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $event->sheet->getStyle('A2:J3')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $event->sheet->mergeCells('A1:J1');
                $event->sheet->mergeCells('A2:B2');
                $event->sheet->mergeCells('C2:J2');
                $event->sheet->mergeCells('A3:B3');
                $event->sheet->mergeCells('C3:J3');
                // Eliminado 'D2:J2' porque ya está fusionado con 'C2:J2'

                $event->sheet->getRowDimension(2)->setRowHeight(60);
                $event->sheet->getRowDimension(1)->setRowHeight(30);
                $event->sheet->getRowDimension(3)->setRowHeight(30);
                $event->sheet->getRowDimension(4)->setRowHeight(30);
                $event->sheet->getDefaultRowDimension()->setRowHeight(50);

                $workSheet = $event->sheet->getDelegate();
                $this->setImage($workSheet);
            },
        ];
    }

    public function headings(): array
    {
        return [
            'Column 1', 'Column 2', 'Column 3', 'Column 4', 'Column 5', 
            'Column 6', 'Column 7', 'Column 8', 'Column 9', 'Column 10'
        ];
    }
}
