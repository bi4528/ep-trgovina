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
        val allUsers = arrayOf(User())

        btnPrijava.setOnClickListener{
            try {
                val email = etEmail.text.toString().trim()
                val splited = email.split("@")
                //email = splited[0] + "%40" + splited[1]
                val x= arrayOf(0)
                thread {
                    val test=Test()
                    val res=test.run(etPassword.text.toString().trim(), etEmail.text.toString().trim())
                    Log.i("HTTPresponse", res)
                    x[0]++
                }



                val intent = Intent(this, MainActivity::class.java)
                val msg = email
                intent.putExtra("email", msg)
                startActivity(intent)
            }catch (e:Exception){
                Log.e("HTTP",e.stackTraceToString())
                tvErr.setText(e.stackTrace.toString())
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


