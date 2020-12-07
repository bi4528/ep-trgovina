package ep.seminarska;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;


//login page
public class LoginPage extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_page);


        EditText etUser = findViewById(R.id.etUsername);
        EditText etPass = findViewById(R.id.etPassword);
        Button btnLogin = findViewById(R.id.btnLogin);
        Button btnReg = findViewById(R.id.btnRegister);
        TextView tv = findViewById(R.id.textView);

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                try {
                    String user = etUser.getText().toString();
                    String pass = etPass.getText().toString();
                } catch (Exception e) {
                    tv.setText("Napaka pri vnosu podatkov. Prosim poskusite ponovno.");
                    e.printStackTrace();
                }
            }
        });

        btnReg.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                Intent myIntent = new Intent(LoginPage.this, RegisterPage.class);
                LoginPage.this.startActivity(myIntent);
            }
        });
    }
}