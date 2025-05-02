<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        $isAdmin = auth()->user()->hasRole('admin');

        return Inertia::render('Article/Index', [
            'articles' => $articles,
            'isAdmin' => $isAdmin,
        ]);
    }

    public function create()
    {
        return Inertia::render('Article/CreateArticle');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'langue' => 'required|string|in:fr,ar',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Article créé avec succès.');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return Inertia::render('Article/EditArticle', [
            'article' => $article,
        ]);
    }

    public function update(Request $request, $id)
    {
         $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);
        $article = Article::findOrFail($id);
        $article->update([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article mis à jour.');
    }



    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès.');
    }

    public function affichage()
    {
        $articles = Article::all();

        return Inertia::render('Article/AffichageArticle', [
            'articles' => $articles,
        ]);
    }

    public function __construct()
    {
        // $this->middleware('role:admin'); // 👈 Active si nécessaire
    }
}
