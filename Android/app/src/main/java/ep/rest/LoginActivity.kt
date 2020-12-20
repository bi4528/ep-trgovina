package ep.rest

import android.content.Intent
import androidx.appcompat.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.widget.Button
import android.widget.EditText
import kotlinx.android.synthetic.main.activity_login.*
import okhttp3.internal.wait
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.lang.Exception
import kotlin.concurrent.thread

class LoginActivity : AppCompatActivity(), Callback<Void> {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_login)
        val etEmail = findViewById<EditText>(R.id.etEmail)
        val etPassword = findViewById<EditText>(R.id.etPassword)
        val btnPrijava = findViewById<Button>(R.id.btnLogin1)
        val btnNazaj = findViewById<Button>(R.id.btnNazaj)
        val allUsers = arrayOf(User())

        btnNazaj.setOnClickListener {
            val intent = Intent(this, MainActivity::class.java)
            startActivity(intent)
        }

        btnPrijava.setOnClickListener{
            try {
                val email = etEmail.text.toString().trim()
               // val splited = email.split("@")
               // email = splited[0] + "%40" + splited[1]
                val pass = etPassword.text.toString().trim()
                val x = arrayOf(0)
                var a=13
                thread {
                    val test=Test()
                    val res=test.run(pass, email)
                    //Log.i("HTTPresponse", res)
                    a=res
                    x[0]++
                }
                while(x[0]<1){
                    Thread.sleep(100)
                }
                Log.i("HTTPSYNC:",x[0].toString())
                Log.i("HTTPX:", a.toString())
                if(a==200){
                    val intent = Intent(this, MainActivity::class.java)
                    val msg = email
                    intent.putExtra("email", msg)
                    startActivity(intent)
                }
                else{
                    tvErr.setText("Uporabniško ime ali geslo je napačno")
                    etEmail.setText("")
                    etPassword.setText("")
                }



            }catch (e:Exception){
                Log.e("HTTP",e.stackTraceToString())
                tvErr.setText("Napaka")
            }
        }

        //)
    }

    override fun onResponse(call: Call<Void>, response: Response<Void>) {
        if (response.isSuccessful){
            Log.i("DB:","success")
        }
        else{
            Log.i("DB:","fail")
        }
    }

    override fun onFailure(call: Call<Void>, t: Throwable) {
        Log.i("sth:", t.stackTrace.toString())
        tvErr.setText("Napaka pri prijavi")

    }

//    override fun onResponse(call: Call<Void>, response: Response<Void>) {
//        if (response.isSuccessful){
//            Log.i("DB: ", "success!")
//        }
//        else{
//            Log.e("errorDB: "," on db comm sth wrong")
//        }
//    }
//
//    override fun onFailure(call: Call<Void>, t: Throwable) {
//        Log.w("tag", "Error: ${t.message}", t)
//    }
}



//}


