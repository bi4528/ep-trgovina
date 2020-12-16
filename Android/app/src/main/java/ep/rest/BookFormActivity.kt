package ep.rest

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import android.util.Log
import kotlinx.android.synthetic.main.activity_book_form.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class BookFormActivity : AppCompatActivity(), Callback<Void> {

    private var book: Book? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_book_form)

        btnSave.setOnClickListener {
            val author = etAuthor.text.toString().trim()
            val title = etTitle.text.toString().trim()
            val description = etDescription.text.toString().trim()
            val price = etPrice.text.toString().trim().toDouble()
            val year = etYear.text.toString().trim().toInt()

            if (book == null) { // dodajanje
                BookService.instance.insert(author, title, price,
                        year, description).enqueue(this)
            } else { // urejanje
                BookService.instance.update(book!!.id, author, title, price,
                        year, description).enqueue(this)
            }
        }

        val book = intent?.getSerializableExtra("ep.rest.book") as Book?
        if (book != null) {
            etAuthor.setText(book.author)
            etTitle.setText(book.title)
            etPrice.setText(book.price.toString())
            etYear.setText(book.year.toString())
            etDescription.setText(book.description)
            this.book = book
        }
    }

    override fun onResponse(call: Call<Void>, response: Response<Void>) {
        val headers = response.headers()

        if (response.isSuccessful) {
            val id = if (book == null) {
                // Preberemo Location iz zaglavja
                Log.i(TAG, "Insertion completed.")
                val parts = headers.get("Location")?.split("/".toRegex())?.dropLastWhile { it.isEmpty() }?.toTypedArray()
                // spremenljivka id dobi vrednost, ki jo vrne zadnji izraz v bloku
                parts?.get(parts.size - 1)?.toInt()
            } else {
                Log.i(TAG, "Editing saved.")
                // spremenljivka id dobi vrednost, ki jo vrne zadnji izraz v bloku
                book!!.id
            }

            val intent = Intent(this, BookDetailActivity::class.java)
            intent.putExtra("ep.rest.id", id)
            startActivity(intent)
        } else {
            val errorMessage = try {
                "An error occurred: ${response.errorBody()?.string()}"
            } catch (e: IOException) {
                "An error occurred: error while decoding the error message."
            }

            Log.e(TAG, errorMessage)
        }
    }

    override fun onFailure(call: Call<Void>, t: Throwable) {
        Log.w(TAG, "Error: ${t.message}", t)
    }

    companion object {
        private val TAG = BookFormActivity::class.java.canonicalName
    }
}
