<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;
use NumberFormatter;
class BlogController extends Controller
{
    public function indexblog()
    {
        $blogs = Blog::all();
        $languages = getWebConfig(name: 'pnc_language') ?? null;
        $defaultLanguage = 'es';
        $blogCount = $blogs->count();
        return view('admin-views.blogs.index', compact('blogs','blogCount'));
    }
    public function portalblog()
    {
        $blogs = Blog::all();
        return view('admin-views.blogs.portal', compact('blogs'));
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function storeblog(Request $request)
    {
         // Consultar los tres primeros registros
        $totalBlogs = Blog::count();
        /*if($totalBlogs == 0){
            $totalBlogsInWords = 'one';
        }*/
        //else{
             // Convertir el número a texto en inglés
            $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
            $totalBlogsInWords = $formatter->format($totalBlogs);
        //}
        
        // Validar si ya existen tres registros
        /*if ($blogs->count() >= 3) {
            return redirect()->back()->with('error', 'No se pueden insertar más de tres blogs.');
        }*/
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
        ]);
        $data['lenguage'] = $request->input('codLen');
        $data['route'] = 'blog_'.$totalBlogsInWords;
        //$data['content'] = $request->input('contenido');

        if ($request->hasFile('image1')) {
            $data['image1'] = $request->file('image1')->store('public/blogs');
        }
        if ($request->hasFile('image2')) {
            $data['image2'] = $request->file('image2')->store('public/blogs');
        }
       /* if ($request->hasFile('image3')) {
            $data['image3'] = $request->file('image3')->store('blogs', 'public');
        }*/

        Blog::create($data);
       
        //return redirect()->route('admin-views.blogs.index')->with('success', 'Blog created successfully');
        return redirect()->back()->with('success', 'Blog creado con exito');
    }
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin-views.blogs.edit', compact('blog'));
    }
    public function update(Request $request, $id)
    {
        // Validar los datos entrantes
        $request->validate([
            'title' => 'required|string|max:255',
            'contentido' => 'required|string',
            //'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            //'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Buscar el blog por ID
        $blog = Blog::findOrFail($id);

        // Actualizar los campos del blog
        $blog->title = $request->input('title');
        $blog->content = $request->input('contentido');
        $blog->lenguage = $request->input('codLen');

        // Manejar las imágenes
        if ($request->hasFile('image1')) {
            $imagePath1 = $request->file('image1')->store('public/blogs');
            $blog->image1 = $imagePath1;
        }

        if ($request->hasFile('image2')) {
            $imagePath2 = $request->file('image2')->store('public/blogs');
            $blog->image2 = $imagePath2;
        }

        // Guardar los cambios
        $blog->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('admin.blogs.indexblog')->with('success', 'Blog actualizado con éxito');
    }
     // Método para eliminar un blog
     public function destroy($id)
     {
         $blog = Blog::find($id);
 
         if ($blog) {
             $blog->delete();
             return response()->json(['message' => 'Blog eliminado con éxito.']);
         } else {
             return response()->json(['message' => 'Blog no encontrado.']);
         }
     }
}
