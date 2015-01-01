// Decompiled by Jad v1.5.8e2. Copyright 2001 Pavel Kouznetsov.
// Jad home page: http://kpdus.tripod.com/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi space 
// Source File Name:   drawMap.java

import java.awt.Color;
import java.awt.Graphics;

class drawMap
{

	private int width;
	private int height;
	private int bar_width;
	private int rect_height;
	private int ox;
	private int oy;
	private Color fg;
	private Color bg;
	private int step_width;
	private int step_height;
	private int box_ox;
	private int box_oy;
	private int bar_high;
	private int times[];
	private String index[] = {
		"\322\366\324\265\317\265\312\375", "\263\311\273\351\317\265\312\375", "\320\324\272\315\320\263\317\265\312\375", "\270\320\307\351\317\265\312\375", "\275\241\277\265\317\265\312\375", "\262\306\324\313\317\265\312\375"
	};

	drawMap(int width, int height, int ox, int oy, int times[])
	{
		this.width = width;
		this.height = height;
		this.ox = ox;
		this.oy = oy;
		this.times = times;
		step_width = width / 7;
		step_height = height / 40;
		bar_width = step_width / 3;
		box_ox = ox;
	}

	void drawFace(Graphics g)
	{
		g.setColor(Color.black);
		g.fillRect(ox, oy, width, height);
		g.setColor(Color.black);
		g.drawLine(ox, oy, ox + width, oy);
		g.drawLine(ox + width, oy, ox + width, oy + height);
		g.drawLine(ox + width, oy + height, ox, oy + height);
		g.drawLine(ox, oy + height, ox, oy);
		for (int i = 0; i < 10; i++)
		{
			g.setColor(new Color(192, 192, 192));
			g.drawLine(ox, oy + step_height * i * 4, ox + width, oy + step_height * i * 4);
			g.setColor(Color.black);
			g.drawString(String.valueOf(100 - i * 10) + "%", 5, 15 + step_height * i * 4);
		}

		g.setColor(Color.black);
		for (int i = 0; i < 6; i++)
			if (i == 2)
				g.drawString(index[i], (ox + step_width * (i + 1)) - 16 - step_width / 3, oy + height + 20);
			else
				g.drawString(index[i], (ox + step_width * (i + 1)) - 10 - step_width / 3, oy + height + 20);

	}

	void indexDraw(Graphics g)
	{
		for (int k = 0; k < 6; k++)
		{
			box_ox = (ox + (k + 1) * step_width) - step_width / 3;
			bar_high = (times[k] * height) / 100;
			barDraw(g);
		}

	}

	void barDraw(Graphics g)
	{
		for (int i = 0; i < bar_high; i++)
		{
			if (i < 156)
				g.setColor(new Color(100 + i, 0, 0));
			else
				g.setColor(new Color(255, i - 100, i - 100));
			box_oy = (oy + height) - i;
			g.drawLine(box_ox, box_oy, box_ox + bar_width, box_oy);
			delay(10000);
		}

	}

	void delay(int num)
	{
		double sum = 1.0D;
		for (int i = 1; i < 4 * num; i++)
			sum *= i;

	}
}
